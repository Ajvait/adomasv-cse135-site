#!/usr/bin/env python3

import os
import datetime

print("Cache-Control: no-cache")
print("Content-Type: text/html\n")

team_name = "Adomas Vaitkus"
language = "Python"
current_time = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
ip_address = os.environ.get("REMOTE_ADDR", "unknown")

print(f"""<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hello HTML – Python</title>
</head>
<body>
  <h1>Hello HTML World</h1>
  <hr>
  <p><strong>Name:</strong> {team_name}</p>
  <p><strong>Language:</strong> {language}</p>
  <p><strong>Date &amp; Time:</strong> {current_time}</p>
  <p><strong>Your IP Address:</strong> {ip_address}</p>
</body>
</html>
""")
