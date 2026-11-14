# Database TLS certificate bundle

`cacert.pem` is the Mozilla CA certificate bundle distributed by curl:
https://curl.se/docs/caextract.html

Source download: https://curl.se/ca/cacert.pem
License: Mozilla Public License 2.0, https://www.mozilla.org/MPL/2.0/

Laravel automatically uses this bundle for MySQL hosts ending in `.tidbcloud.com`,
including hosts provided in `DB_URL`. Certificate verification remains enabled.
An explicit `MYSQL_ATTR_SSL_CA` absolute path overrides the bundled certificate store.
Local MySQL connections do not enable TLS automatically.

Keep this file in the deployment alongside `config/database.php`. To refresh the
bundle from PowerShell, run from the project root:

```powershell
Invoke-WebRequest https://curl.se/ca/cacert.pem -OutFile resources/certs/cacert.pem
```
