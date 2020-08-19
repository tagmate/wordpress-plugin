# tagmate.io WordPress Plugin


## Run

0. (Optional) Add `127.0.0.1 tagmate.local` to your `/etc/hosts`
1. Run `docker-compose up -d`
2. Setup your WordPress instance
3. Go to `Plugins` and activate the tagmate.io plugin
4. You can fin the plugin setting page at `Settings > Tagmate`

## Test

You can use `tgm-4d3m0` as a *Platform ID* with any fake *User ID* (optional) to test the plugin.

## Deploy an update to the WordPress Plugin Directory

0. Install subversion/SVN CLI
1. Clone the reporsitory using and your username+pwd:
```
svn checkout --depth immediates https://plugins.svn.wordpress.org/tagmate-io-code-snippet-installer/ svn
```
2. Make sure the code is up to date by runing:
```
cd svn
svn update --set-depth infinity assets
svn update --set-depth infinity trunk
svn update --set-depth infinity tags
svn update --set-depth infinity branches
```
3. Update the changelogs, versionm and validate the `readme.txt` file using [this tool](https://wordpress.org/plugins/developers/readme-validator/)
4. Copy the updated version to the `trunk/` directory (`n.n.n` is the vertsion tag represented in numbers):
```
cp -rf ../tagmate-plugin/* trunk/
cp -rf ../tagmate-plugin/* tags/n.n.n/*
```
5. Compress 'trunk' as a .zip and test it on the targeted WordPress versions to QA test the plugin before an update
6. Add the changes
```
svn add . --force
```
7. Fix screenshots MIME types (to avoid downloading them when clicking):
```
svn propset svn:mime-type image/png assets/*.png || true
svn propset svn:mime-type image/jpeg assets/*.jpg || true
```
8. Commit+push the updated to WP Plugin Directory:
```
svn ci -m 'Adding first version of my plugin'
```
9. Make sure the new version is added by going to [plugin's SVN repo](https://plugins.svn.wordpress.org/tagmate-io-code-snippet-installer/) and checking [the plugin link on WordPress.org](https://wordpress.org/plugins/tagmate-io-code-snippet-installer/)
10. Good luck! 🤞

 ## License: GPL v2 or later

Copyright Hicham Abdelkaoui (hicham@tagmate.io), inspired by Thomas Geiger's Google Tag Manager for WordPress (https://wordpress.org/plugins/duracelltomi-google-tag-manager)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
