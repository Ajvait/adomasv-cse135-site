package main

import (
	"bufio"
	"fmt"
	"net/http"
	"os"
	"strings"
	"time"
)

func main() {
	reader := bufio.NewReader(os.Stdin)
	req, err := http.ReadRequest(reader)
	if err != nil {
		fmt.Println("Content-Type: text/plain\n")
		fmt.Println("Failed to read request")
		return
	}

	cookie, err := req.Cookie("SESSION_ID")
	sessionID := ""
	if err == nil {
		sessionID = cookie.Value
	} else {
		sessionID = fmt.Sprintf("%d", time.Now().UnixNano())
	}

	sessionFile := "/tmp/session-go-" + sessionID + ".txt"

	req.ParseForm()
	message := req.FormValue("message")
	clear := req.FormValue("clear")

	if clear != "" {
		os.Remove(sessionFile)
	}

	if message != "" {
		os.WriteFile(sessionFile, []byte(message), 0644)
	}

	stored := "(nothing stored yet)"
	if data, err := os.ReadFile(sessionFile); err == nil {
		stored = string(data)
	}

	fmt.Println("Content-Type: text/html; charset=utf-8")
	fmt.Printf("Set-Cookie: SESSION_ID=%s; Path=/\n\n", sessionID)

	fmt.Println(`
<!DOCTYPE html>
<html>
<head>
  <title>State Demo — Go</title>
</head>
<body>
  <h1>State Demo — Go</h1>

  <form method="POST">
    <label>Enter a message to save:</label><br>
    <input type="text" name="message">
    <button type="submit">Save</button>
  </form>

  <form method="POST" style="margin-top:10px;">
    <input type="hidden" name="clear" value="1">
    <button type="submit">Clear Session</button>
  </form>

  <h2>Stored Value</h2>
  <p>` + htmlEscape(stored) + `</p>

  <hr>
  <p><strong>Session ID:</strong> ` + sessionID + `</p>
  <p><strong>Language:</strong> Go</p>
</body>
</html>
`)
}

func htmlEscape(s string) string {
	replacer := strings.NewReplacer(
		"&", "&amp;",
		"<", "&lt;",
		">", "&gt;",
	)
	return replacer.Replace(s)
}
