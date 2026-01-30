#!/usr/bin/env python3

import os
import sys
import json
import datetime
from urllib.parse import parse_qs

print("Cache-Control: no-cache, no-store, must-revalidate")
print("Pragma: no-cache")
print("Expires: 0")
print("Content-Type: text/html\n")

method = os.environ.get("REQUEST_METHOD", "")
host = os.environ.get("HTTP_HOST", "")
user_agent = os.environ.get("HTTP_USER_AGENT", "")
ip_address = os.environ.get("REMOTE_ADDR", "")
content_type = os.environ.get("CONTENT_TYPE", "")
query_string = os.environ.get("QUERY_STRING", "")
datetime_now = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")

data = {}

if method == "GET":
    data = parse_qs(query_string)

elif method in ("POST", "PUT", "DELETE"):
    content_length = int(os.environ.get("CONTENT_LENGTH", 0))
    raw_body = sys.stdin.read(content_length)

    if "application/json" in content_type:
        try:
            data = json.loads(raw_body)
        except json.JSONDecodeError:
            data = {}
    else:
        data = parse_qs(raw_body)

print(f"""<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Echo – Python</title>
  <style>
    body {{
      font-family: Arial, sans-serif;
    }}
    pre {{
      background: #f4f4f4;
      padding: 10px;
      border: 1px solid #ccc;
    }}
  </style>
</head>
<body>

<h1>Echo (Python)</h1>

<h2>Request Information</h2>
<ul>
  <li><strong>Method:</strong> {method}</li>
  <li><strong>Host:</strong> {host}</li>
  <li><strong>Date & Time:</strong> {datetime_now}</li>
  <li><strong>User Agent:</strong> {user_agent}</li>
  <li><strong>IP Address:</strong> {ip_address}</li>
</ul>

<h2>Received Data</h2>
<pre>{json.dumps(data, indent=2)}</pre>

</body>
</html>
""")
