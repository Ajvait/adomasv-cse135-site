#!/usr/bin/env python3

import os

print("Cache-Control: no-cache, no-store, must-revalidate")
print("Pragma: no-cache")
print("Expires: 0")
print("Content-Type: text/html\n")

print("""<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Environment Variables – Python</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 6px 10px;
      text-align: left;
      font-family: monospace;
      vertical-align: top;
    }
    th {
      background-color: #f4f4f4;
    }
  </style>
</head>
<body>

<h1>Environment Variables (Python)</h1>

<table>
  <tr>
    <th>Variable</th>
    <th>Value</th>
  </tr>
""")

for key, value in sorted(os.environ.items()):
    print(f"<tr><td>{key}</td><td>{value}</td></tr>")

print("""
</table>

</body>
</html>
""")
