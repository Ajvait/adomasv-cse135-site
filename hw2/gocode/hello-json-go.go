package main

import (
	"encoding/json"
	"fmt"
	"os"
	"time"
)

func main() {
	fmt.Println("Content-Type: application/json; charset=utf-8")
	fmt.Println()

	ip := os.Getenv("HTTP_X_REAL_IP")
	if ip == "" {
		ip = os.Getenv("REMOTE_ADDR")
	}

	response := map[string]string{
		"name":      "Adomas Vaitkus",
		"language":  "Go",
		"datetime":  time.Now().Format("2006-01-02 15:04:05"),
		"ip":        ip,
	}

	encoder := json.NewEncoder(os.Stdout)
	encoder.SetIndent("", "  ")
	encoder.Encode(response)
}
