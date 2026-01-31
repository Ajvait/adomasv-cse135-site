package main

import (
	"fmt"
	"os"
	"sort"
)

func main() {
	fmt.Println("Content-Type: text/html; charset=utf-8")
	fmt.Println()

	fmt.Println(`<!DOCTYPE html>
<html>
<head>
  <title>Environment Variables (Go)</title>
  <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
  <h1>Environment Variables (Go)</h1>
  <table>
    <tr>
      <th>Variable</th>
      <th>Value</th>
    </tr>`)

	env := os.Environ()
	sort.Strings(env)

	for _, e := range env {
		fmt.Printf("<tr><td>%s</td><td>%s</td></tr>\n",
			htmlEscape(e[:indexOf(e, '=')]),
			htmlEscape(e[indexOf(e, '=')+1:]),
		)
	}

	fmt.Println(`</table>
  <hr>
  <p><strong>Language:</strong> Go</p>
</body>
</html>`)
}

func indexOf(s string, c rune) int {
	for i, r := range s {
		if r == c {
			return i
		}
	}
	return -1
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
