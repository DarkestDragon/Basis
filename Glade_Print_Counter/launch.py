#!/usr/bin/env python3
# -*- coding: utf-8 -*-

#Printer Window script
#Gorbunov N.N. (C)2019

import gi, time
gi.require_version("Gtk", "3.0")
from gi.repository import Gtk
zebraFound = True
try:
	from zebra import zebra
except Exception as err:
	print(str(err) + "\nOutput will be in terminal.\n")
	zebraFound = False
import os

class PrintingWindow():
	def __init__(self):
		self.builder = Gtk.Builder()
		self.builder.add_from_file("Glade_Print_Counter.glade")
		self.window = self.builder.get_object("PrinterWindow")
		closeBtn = self.builder.get_object("CloseBtn")
		printBtn = self.builder.get_object("PrintBtn")
		printNumBtn = self.builder.get_object("PrintNumBtn")
		self.pauseBtn = self.builder.get_object("PauseBtn")
		self.pauseFlag = False#if this flag set to true, then printing will be paused
		closeBtn.connect("clicked", self.quit)
		self.pauseBtn.connect("clicked", self.pause)
		#closeBtn.connect("clicked", self.debug_quit)#for debug
		self.window.connect("destroy", self.quit)
		if zebraFound == True:
			printNumBtn.connect("clicked", self.print_number)
			self.z = zebra('Zebra-Technologies-ZTC-GK420d')
			if(type(self.z) is zebra):
				printBtn.connect("clicked", self.printing_process)
			else:
				print("Printer wasn't detected! Output will be in terminal.\n")
				printBtn.connect("clicked", self.virtual_print)
		else:
			printBtn.connect("clicked", self.virtual_print)#for debug or emulation mode
		
		#Restoring "Printed" last value
		printed_entry = self.builder.get_object("Printed")
		try:#opening file with "Printed" last value
			printedFile = open("./printed.txt", 'r')
			printed = int(printedFile.read())
			printedFile.close()
			printed_entry.set_text(str(printed))
		except:
			print("printed.txt not found! New one will be created!\n")
		self.window.show_all()
		
	def quit(self, widget):
		#Saving "Printed" value
		entry_quit = self.builder.get_object("Printed")
		printed = int(entry_quit.get_text())
		printedFile = open("./printed.txt", 'w')
		printedFile.write(str(printed))
		printedFile.close()
		
		Gtk.main_quit()#closing window
		
	def debug_quit(self, widget):
		Gtk.main_quit()
	
	def printing_process(self, widget):
		#Preparing objects
		entry1 = self.builder.get_object("Printed")
		entry2 = self.builder.get_object("LeftToPrint")
		entry3 = self.builder.get_object("Port")
		printed = int(entry1.get_text())
		must_print = int(entry2.get_text())
		printer_port = str(entry3.get_active_text())
		#Printing
		self.z.setup( direct_thermal=True, label_height=(200,2), label_width=200 )
		while must_print != 0:
			if self.pauseFlag == True:
				Gtk.main_iteration_do(False)
				continue
			must_print -= 1
			printed += 1
			# print a page here
			self.printDMC(self.z, str(printed))
			#Tranziting new values to widgets
			entry1.set_text(str(printed))
			entry2.set_text(str(must_print))
			Gtk.main_iteration_do(False)#TODO: find a better function for window render update
			time.sleep(0.05)
	
	def pause(self, widget):
		if self.pauseFlag == False:
			self.pauseFlag = True
			self.pauseBtn.set_label("Продолжить")
			return
		else:
			self.pauseFlag = False
			self.pauseBtn.set_label("Пауза")
			return
	
	def print_number(self, widget):
		#Preparing number and port
		entry1 = self.builder.get_object("TestNumField")
		entry2 = self.builder.get_object("Port")
		self.z.setup( direct_thermal=True, label_height=(200,2), label_width=200 )
		testNum = entry1.get_text()
		printer_port = str(entry2.get_active_text())
		self.printDMC(self.z, testNum)
		entry1.set_text("")
		Gtk.main_iteration_do(False)
		
			
	def virtual_print(self, widget):#function for window debugging
		entry1 = self.builder.get_object("Printed")
		entry2 = self.builder.get_object("LeftToPrint")
		printed = int(entry1.get_text())
		must_print = int(entry2.get_text())
		while must_print != 0:
			if self.pauseFlag == True:
				Gtk.main_iteration_do(False)
				continue
			print("Print")
			must_print -= 1
			printed += 1
			print(str(printed))
			print(str(must_print))
			entry1.set_text(str(printed))
			entry2.set_text(str(must_print))
			Gtk.main_iteration_do(False)
			time.sleep(0.05)

	def printDMC(self, zebra, num2prnt):
		zebra.output('^XA')#begining of cmds
		zebra.output('^FO 50,20')#margin
		zebra.output('^BXN,10,200')#barcode
		zebra.output('^FD'+num2prnt+'^FS')#barcode value
		zebra.output('^FO50,130^ADN,26,12^FD'+num2prnt.zfill(8)+'^FS')#under barcode sign
		zebra.output('^XZ')#end of cmds
		time.sleep(0.05)


window = PrintingWindow()
Gtk.main()
