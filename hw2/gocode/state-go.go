package main

import (
	"fmt"
	"os"
	"strings"
	"io/ioutil"
	"net/url"
	"crypto/rand"
	"encoding/hex"
)

func newSessionID() string {
	b := make([]byte, 16)
	_, _ = rand.Read(b)
	return hex.EncodeToString(b)
}

func main() {
	cookies := os.Getenv("HTTP_COOKIE")
	sessionID := ""

	for _, c := range strings.Split(cookies, ";") {
		c = strings.TrimSpace(c)
		if strings.HasPrefix(c, "SESSION_ID=") {
			sessionID = strings.TrimPrefix(c, "SESSION_ID=")
		}
	}

	if sessionID == "" {
		sessionID = newSessionID()
	}

	sessionFile := "/tmp/session_" + sessionID + ".txt"

	method := os.Getenv("REQUEST_METHOD")
	form := map[string]string{}

	if method == "POST" {
		length := os.Getenv("CONTENT_LENGTH")
		if length != "" {
			body, _ := ioutil.ReadAll(os.Stdin)
			values, _ := url.ParseQuery(string(body))
			for k, v := range values {
				form[k] = v[0]
			}
		}
	} else {
		values, _ := url.ParseQuery(os.Getenv("QUERY_STRING"))
		for k, v := range values {
			form[k] = v[0]
		}
	}

	if _, ok := form["clear"]; ok {
		os.Remove(sessionFile)
	}

	if msg, ok := form["message"]; ok && msg != "" {
		_ = ioutil.WriteFile(sessionFile, []byte(msg), 0644)
	}

	stored := ""
	if data, err := ioutil.ReadFile(sessionFile); err == nil {
		stored = string(data)
	}

	if stored == "" {
		stored = "(nothing stored yet)"
	}

	fmt.Println("Content-Type: text/html; charset=utf-8")
	fmt.Printf("Set-Cookie: SESSION_ID=%s; Path=/\n\n", sessionID)

	fmt.Printf(`<!DOCTYPE html>
<html>
<head>
  <title>State Demo (Go)</title>
</head>
<body>
  <h1>State Demo — Go</h1>

  <form method="POST">
    <label>Enter a message to save:</label><br>
    <input type="text" name="message" />
    <button type="submit">Save</button>
  </form>

  <form method="POST" style="margin-top:10px;">
    <input type="hidden" name="clear" value="1">
    <button type="submit">Clear Session</button>
  </form>

  <h2>Stored Value</h2>
  <p>%s</p>

  <hr>
  <p><strong>Session ID:</strong> %s</p>
  <p><strong>Language:</strong> Go</p>
</body>
</html>`,
		stored, sessionID)
}
