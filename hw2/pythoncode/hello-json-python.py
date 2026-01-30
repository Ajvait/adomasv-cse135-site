#!/usr/bin/env python3

import os
import datetime
import json

print("Cache-Control: no-cache")
print("Content-Type: application/json\n")

data = {
    "message": "Hello JSON World",
    "name": "Adomas Vaitkus",
    "language": "Python",
    "date_time": datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
    "ip_address": os.environ.get("REMOTE_ADDR", "unknown")
}

print(json.dumps(data, indent=2))
