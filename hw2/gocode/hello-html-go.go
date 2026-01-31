package main

import (
	"fmt"
	"net/http"
	"os"
	"time"
)

func main() {
	w := os.Stdout

	fmt.Fprintln(w, "Content-Type: text/html; charset=utf-8")
	fmt.Fprintln(w)

	name := "Adomas Vaitkus"
	language := "Go"
	now := time.Now().Format("2006-01-02 15:04:05")

	ip := os.Getenv("REMOTE_ADDR")
	if forwarded := os.Getenv("HTTP_X_FORWARDED_FOR"); forwarded != "" {
		ip = forwarded
	}

	fmt.Fprintln(w, `<!DOCTYPE html>
<html>
<head>
  <title>Hello HTML World</title>
</head>
<body>

<h1>Hello HTML World</h1>
<hr>

<p><strong>Name:</strong> `+name+`</p>
<p><strong>Language:</strong> `+language+`</p>
<p><strong>Date & Time:</strong> `+now+`</p>
<p><st
