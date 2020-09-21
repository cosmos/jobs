# Cosmos Job Board Child Theme

Cosmos Job Board is based on WP-Job Manager running on WP and the Front Theme and customized by Todd Santoro

## Installation

Use the package manager [npm](https://www.npmjs.com/) to install Cosmos Job Board Child Theme.

```bash	
npm install
```
Gulp is the build manager and is needed to start the dev process so run one of ther following commands
```bash start
gulp
```
```bash
gulp build --prod
```
OR
```bash start
npm run start
```
```bash
npm run build
```
Once the production build is complete you will need to manually upload the `dist` folder to the root of this child theme. You can also build a pipline to automate this. The `dist` and `node_modules` folders are never included in the repository because these assets can be recreated from their respective build files. You may have to update your .gitignore file in the root of this WP install. Typically WP and the respective plugins are not included in the repository either. Typically the theme is the only thing included in the repository unless you are building a plugin and then that would also be included in the repository too.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[GPL](https://www.gnu.org/licenses/gpl-3.0.en.html)