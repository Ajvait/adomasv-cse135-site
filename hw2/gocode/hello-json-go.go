package main

import (
	"encoding/json"
	"fmt"
	"os"
	"time"
)

func main() {
	// CGI header
	fmt.Println("Content-Type: application/json; charset=utf-8")
	fmt.Println()

	// Get client IP (works behind Apache)
	ip := os.Getenv("HTTP_X_REAL_IP")
	if ip == "" {
		ip = os.Getenv("REMOTE_ADDR")
	}

	// Build response object
	response := map[string]string{
		"name":      "Adomas Vaitkus",
		"language":  "Go",
		"datetime":  time.Now().Format("2006-01-02 15:04:05"),
		"ip":        ip,
	}

	// Encode as JSON
	encoder := json.NewEncoder(os.Stdout)
	encoder.SetIndent("", "  ")
	encoder.Encode(response)
}
