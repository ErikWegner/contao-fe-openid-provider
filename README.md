# Contao 4 OpenID provider for frontend users

Contao is an Open Source PHP Content Management System for people who want a
professional website that is easy to maintain. Visit the [project website][1]
for more information.

This bundle contains a simple provider for OAuth authorization for
single sign on applications. User credentials are stored in Contao and user
details are available through the OpenID mechanism.

## Installation

For detailed instruction, see [library instructions][2].

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

[1]: https://contao.org
[2]: https://oauth2.thephpleague.com/installation/