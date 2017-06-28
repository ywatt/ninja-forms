# Feature - Remote Plugin Installation

The **Remote Plugin Installation** feature introduces an authentication based process which connects to a remove server for the purpose of programmatically installing plugins without needing to manually download - and then subsequently upload - zipped plugin files.

## Terminology

**Service** - My.NinjaForms.com Service

**Site Manager** - Site Manager (JS) Application - Hosted on the **Service**

**Plugin** - Ninja Forms plugin (installed on a user's WordPress installation)

## Dependencies

The Remote Plugin Installation feature requires that the following are installed on the **Service** site.

- WP OAuth Server - https://wp-oauth.com/
- Easy Digital Downloads - https://easydigitaldownloads.com/
  - EDD Software Licensing - https://easydigitaldownloads.com/downloads/software-licensing/
  - EDD Remote Plugin Installer - https://github.com/aristath/edd-remote-installer

## Security

Requests between the **Service** and the **Plugin** are sent as WebHook requests and are always signed.

For more information on the WebHooks system, see `includes/WebHooks/README.md`.

Each request's `payload` is accompanied by a corresponding `hash` which is generated using the combination of the `payload`, the OAuth client ID, and the OAuth client secret. The OAuth client secret is known by both the **Service** and the **Plugin**, but is never transmitted after the client's initial registration.

NOTE: The exception to this is the actual download of the plugin zip, which requires that the requesting site is already activated on the `license` accompanying the request.

## Request Flow

From the **Plugin** dashboard, a user "connects" to the **Service**. After authentication, the site's URL is registered as an oauth client.
See: `_docs/OAUTH`.

From the **Site Manager**, the user chooses to activate a specific add-on for a registered WordPress install.

The **Site Manager** sends a request to the **Service** requesting that the specified plugin be installed on the specified client website.

The **Service** sends a request to the specified client's URL (`redirect_uri`) that the specified plugin be installed. The request includes the Download Name (`download`), License Key (`license`), and the Download Slug (`slug`).

The **Plugin** builds a `download link`, using the `download` and the `license`, which is passed to the WordPress `Plugin_Updater`. See: `includes/WebHooks/WebHookInstall.php`.

The **Service**, by means of the `EDD Remote Plugin Installer` plugin, verifies the request and responds with the plugin zip download.

The **Plugin** confirms that the plugin file has been installed, using the `destination_name` provided by the `Plugin_Updater`, then attempts to activate the installed plugin. If the installed plugin is active, then the `license` is stored in the database using the corresponding `slug`.
