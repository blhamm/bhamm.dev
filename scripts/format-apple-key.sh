#!/bin/bash

# Utility to format Apple .p8 private keys for .env files
# Usage: ./scripts/format-apple-key.sh <path-to-p8-file> [--newline]

FILE=$1
MODE="base64"

if [[ "$2" == "--newline" ]]; then
    MODE="newline"
fi

if [[ -z "$FILE" ]] || [[ ! -f "$FILE" ]]; then
    echo "Usage: $0 <path-to-p8-file> [--newline]"
    echo "Default mode is Base64 (recommended)."
    echo "Use --newline to output a single-line string with literal \\n characters."
    exit 1
fi

if [[ "$MODE" == "base64" ]]; then
    # Convert PKCS#1 to PKCS#8 if needed, base64 encode, and strip newlines
    CONVERTED=$(openssl pkey -outform PEM 2>/dev/null < "$FILE" || cat "$FILE")
    ENCODED=$(echo "$CONVERTED" | base64 | tr -d '\n')
    echo "APPLE_PRIVATE_KEY=\"$ENCODED\""
else
    # Convert PKCS#1 to PKCS#8 if needed, replace actual newlines with literal \n
    CONVERTED=$(openssl pkey -outform PEM 2>/dev/null < "$FILE" || awk '{printf "%s\\n", $0}' "$FILE" | sed 's/\\n$//')
    echo "APPLE_PRIVATE_KEY=\"$CONVERTED\""
fi
