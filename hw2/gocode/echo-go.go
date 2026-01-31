package main

import (
	"fmt"
	"os"
	"strings"
	"time"
)

func main() {
	// CGI header
	fmt.Println("Content-Type: text/html; charset=utf-8")
	fmt.Println()

	method := os.Getenv("REQUEST_METHOD")
	query := os.Getenv("QUERY_STRING")
	host := os.Getenv("HTTP_HOST")
	ua := os.Getenv("HTTP_USER_AGENT")
	ip := os.Getenv("REMOTE_ADDR")
	now := time.Now().Format("2006-01-02 15:04:05")

	params := make(map[string]string)

	// Parse GET
	if method == "GET" && query != "" {
		parseParams(query, params)
	}

	// Parse POST (x-www-form-urlencoded)
	if method == "POST" {
		contentLength := os.Getenv("CONTENT_LENGTH")
		if contentLength != "" {
			var body string
			fmt.Fscan(os.Stdin, &body)
			parseParams(body, params)
		}
	}

	fmt.Println(`<!DOCTYPE html>
<html>
<head>
  <title>Echo Demo (Go)</title>
  <style>
    table { border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 6px; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
  <h1>Echo Demo — Go</h1>

  <p><strong>Method:</strong> ` + method + `</p>
  <p><strong>Host:</strong> ` + host + `</p>
  <p><strong>Date & Time:</strong> ` + now + `</p>
  <p><strong>User Agent:</strong> ` + ua + `</p>
  <p><strong>Your IP:</strong> ` + ip + `</p>

  <h2>Received Parameters</h2>
  <table>
    <tr><th>Key</th><th>Value</th></tr>`)

	if len(params) == 0 {
		fmt.Println("<tr><td colspan='2'>(no parameters received)</td></tr>")
	} else {
		for k, v := range params {
			fmt.Printf("<tr><td>%s</td><td>%s</td></tr>\n",
				htmlEscape(k), htmlEscape(v))
		}
	}

	fmt.Println(`</table>

  <hr>
  <p><strong>Language:</strong> Go</p>
</body>
</html>`)
}

// Helpers

func parseParams(s string, params map[string]string) {
	pairs := strings.Split(s, "&")
	for _, p := range pairs {
		kv := strings.SplitN(p, "=", 2)
		if len(kv) == 2 {
			params[urlDecode(kv[0])] = urlDecode(kv[1])
		}
	}
}

func urlDecode(s string) string {
	s = strings.ReplaceAll(s, "+", " ")
	return s
}

func htmlEscape(s string) string {
	replacer := map[rune]string{
		'<': "&lt;",
		'>': "&gt;",
		'&': "&amp;",
		'"': "&quot;",
	}
	out := ""
	for _, r := range s {
		if v, ok := replacer[r]; ok {
			out += v
		} else {
			out += string(r)
		}
	}
	return out
}
