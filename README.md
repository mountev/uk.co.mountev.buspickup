# uk.co.mountev.buspickup

![Screenshot](/images/screenshot.png)

Global screen for configuring bus locations and timings. Auto update timings based on location when a contact, custom set or relationship is created or updated. Once timings are set mailing tokens for custom fields could be used.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v5.6+
* CiviCRM v5.0+

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl uk.co.mountev.buspickup@https://github.com/mountev/uk.co.mountev.buspickup/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/mountev/uk.co.mountev.buspickup.git
cv en buspickup
```

## Usage

- Enable new permission 'edit buspickup locations' for roles responsible for updating locations.
- Visit Admin > System Settings > Bus Pickup Locations to update locations and timings.
- When a Contact, Custom Set (Individual Details) or Relationship (Team member of) is created or updated, it should automatically set "Bus Pickup Time" custom field of "Individual Details" custom set.
