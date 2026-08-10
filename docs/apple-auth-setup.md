# Apple Authentication Setup Guide

This guide explains how to configure Apple Sign-in for the application, specifically focusing on managing the required private key (`.p8` file).

## Prerequisites

1.  An Apple Developer account.
2.  An App ID and a Service ID configured for Sign-in with Apple.
3.  A Private Key (`.p8` file) generated from the Apple Developer Console.

## Environment Variables

Add the following variables to your `.env` file:

```env
APPLE_CLIENT_ID=com.example.service
APPLE_TEAM_ID=XXXXXXXXXX
APPLE_KEY_ID=XXXXXXXXXX
APPLE_PRIVATE_KEY="..."
APPLE_REDIRECT_URI="${APP_URL}/auth/apple/callback"
```

## Formatting the Private Key

Apple's private keys are provided in PEM format, which contains multiple lines and specific whitespace. This can be difficult to store directly in `.env` files.

We provide a utility script to convert your `.p8` file into a format that is safe for `.env` files.

### Method 1: Base64 Encoding (Recommended)

Base64 is the most robust way to store binary or multi-line data in environment variables.

1.  Run the formatting script:
    ```bash
    ./scripts/format-apple-key.sh /path/to/your/AuthKey_XXXXXXXXXX.p8
    ```
2.  Copy the output and paste it into your `.env` file for `APPLE_PRIVATE_KEY`.

The application will automatically detect that the key is Base64 encoded and decode it at runtime.

### Method 2: Escaped Newlines

If you prefer to keep the key in a human-readable (though single-line) format, you can use escaped newlines.

1.  Run the formatting script with the `--newline` flag:
    ```bash
    ./scripts/format-apple-key.sh /path/to/your/AuthKey_XXXXXXXXXX.p8 --newline
    ```
2.  Copy the output and paste it into your `.env` file. Ensure the value is wrapped in double quotes.

## Troubleshooting

- **Invalid Key**: Ensure you copied the entire output of the script, including the double quotes if applicable.
- **Decoding Error**: If you manually encoded the key, ensure it is standard Base64 without line breaks.
- **Provider Error**: Verify that your `APPLE_TEAM_ID` and `APPLE_KEY_ID` match exactly what is in the Apple Developer Console.
