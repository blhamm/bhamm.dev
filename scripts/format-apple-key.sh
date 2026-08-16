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
    # Base64 encode and strip any newlines from the base64 output
    ENCODED=$(base64 < "$FILE" | tr -d '\n')
    echo "APPLE_PRIVATE_KEY=\"$ENCODED\""
else
    # Replace actual newlines with literal \n
    # Note: This uses awk to join lines with \n string
    ESCAPED=$(awk '{printf "%s\\n", $0}' "$FILE" | sed 's/\\n$//')
    echo "APPLE_PRIVATE_KEY=\"$ESCAPED\""
fi
