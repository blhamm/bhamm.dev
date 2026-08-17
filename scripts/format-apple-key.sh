#!/bin/bash

# Utility to format Apple .p8 private keys for .env files
# Usage: ./scripts/format-apple-key.sh <path-to-p8-file>

FILE=$1

if [[ -z "$FILE" ]] || [[ ! -f "$FILE" ]]; then
    echo "Usage: $0 <path-to-p8-file>"
    echo "Newlines the key into a single line with literal \\n characters, then base64 encodes it."
    exit 1
fi

# Replace actual newlines with literal \n, then base64 encode the result
ESCAPED=$(awk '{printf "%s\\n", $0}' "$FILE" | sed 's/\\n$//')
ENCODED=$(echo -n "$ESCAPED" | base64 | tr -d '\n')
echo "APPLE_PRIVATE_KEY=\"$ENCODED\""
