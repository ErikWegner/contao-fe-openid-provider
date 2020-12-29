# Contao 4 OpenID provider for frontend users

Contao is an Open Source PHP Content Management System for people who want a
professional website that is easy to maintain. Visit the [project website][1]
for more information.

This bundle contains a simple provider for OAuth authorization for
single sign on applications. User credentials are stored in Contao and user
details are available through the OpenID mechanism.

## Installation

1. Install this extension with composer.
2. Then create the required keys. For detailed instruction, see [library instructions][2].
3. Configure the extension.

Install:

    composer require erikwegner/fe-openid-provider

Generate a key:

    openssl genrsa -out private.key 2048

Extract the public key from the private key

    openssl rsa -in private.key -pubout -out public.key

The private key must be kept secret (i.e. out of the web-root of the
authorization server). The authorization server also requires the public key.

Generate a string password:

    php -r 'echo base64_encode(random_bytes(32)), PHP_EOL;'

Add settings to `app/config/config.yml`:

```yml
contao:
  localconfig:
    feopenidprovider:
      keypath: <path to generated keys>
      encryptionkey: <generated string password>
```

## Usage

1. Create a client in Contao (System » Members-OpenID).
2. Setup a login page at `/fe-login.html`.
    1. Create a page.
    2. Add a login form.
    3. Enable _Redirect back_ for the login form.

### Client OpenID settings:

Grant Type: `authorization code`
Callback URL: One of the configured redirect URI values
Auth URL: `https://your.contao.install/fe/authorize`
Access Token URL: `https://your.contao.install/fe/access_token`
Client ID: The configured `identifier` for the app
Scope: email|basic

[1]: https://contao.org
[2]: https://oauth2.thephpleague.com/installation/
