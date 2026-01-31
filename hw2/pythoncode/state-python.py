#!/usr/bin/env python3

import os
import sys
import cgi
import cgitb
import http.cookies
import uuid

cgitb.enable()

cookie = http.cookies.SimpleCookie(os.environ.get("HTTP_COOKIE"))
session_id = cookie.get("SESSION_ID")

if session_id:
    session_id = session_id.value
else:
    session_id = str(uuid.uuid4())

session_file = f"/tmp/session_{session_id}.txt"

form = cgi.FieldStorage()
message = form.getvalue("message")
clear = form.getvalue("clear")

if clear:
    if os.path.exists(session_file):
        os.remove(session_file)

if message:
    with open(session_file, "w") as f:
        f.write(message)

stored_value = ""
if os.path.exists(session_file):
    with open(session_file, "r") as f:
        stored_value = f.read()

print("Content-Type: text/html")
print(f"Set-Cookie: SESSION_ID={session_id}; Path=/")
print()

print(f"""
<!DOCTYPE html>
<html>
<head>
  <title>State Demo (Python)</title>
</head>
<body>
  <h1>State Demo — Python</h1>

  <form method="POST">
    <label>Enter a message to save:</label><br>
    <input type="text" name="message" />
    <button type="submit">Save</button>
  </form>

  <form method="POST" style="margin-top: 10px;">
    <input type="hidden" name="clear" value="1">
    <button type="submit">Clear Session</button>
  </form>

  <h2>Stored Value</h2>
  <p>{stored_value if stored_value else "(nothing stored yet)"}</p>

  <hr>
  <p><strong>Session ID:</strong> {session_id}</p>
  <p><strong>Language:</strong> Python</p>
</body>
</html>
""")
