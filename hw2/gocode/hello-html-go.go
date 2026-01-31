package main

import (
	"fmt"
	"os"
	"time"
)

func main() {
	fmt.Println("Content-Type: text/html; charset=utf-8")
	fmt.Println()

	ip := os.Getenv("REMOTE_ADDR")
	now := time.Now().Format(time.RFC1123)

	fmt.Printf(`<!DOCTYPE html>
<html>
<head>
  <title>Hello HTML — Go</title>
</head>
<body>
  <h1>Hello from Go</h1>
  <p><strong>Language:</strong> Go</p>
  <p><strong>Time:</strong> %s</p>
  <p><strong>Your IP:</strong> %s</p>
</body>
</html>
`, now, ip)
}
