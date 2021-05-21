const fs = require('fs');
const cpx = require('cpx');
const dir = JSON.parse(fs.readFileSync('./package.json', 'utf8')).config.dir;
const dirTmp = 'sub';
const sitemap = JSON.parse(fs.readFileSync('./src/config/json/setting.json', 'utf8')).directory;

if (fs.existsSync(`${dir.src}${dirTmp}`)) {
	for (const [slugSub, valueSub] of Object.entries(sitemap)) {
		if (!fs.existsSync(`${dir.src}${slugSub}`) && slugSub.indexOf('.') < 0) {
			cpx.copy(`${dir.src}${dirTmp}/!(${dirTmp})/**`, `${dir.src}${slugSub}/`, {includeEmptyDirs: true});
			cpx.copy(`${dir.src}${dirTmp}/*.{html,php}`, `${dir.src}${slugSub}/`);
		}

		if (fs.existsSync(`${dir.src}${dirTmp}/${dirTmp}`) && valueSub.cascade) {
			for (const [slugSubSub, valueSubSub] of Object.entries(valueSub.cascade)) {
				if (!fs.existsSync(`${dir.src}${slugSub}/${slugSubSub}`) && slugSubSub.indexOf('.') < 0) {
					cpx.copy(`${dir.src}${dirTmp}/${dirTmp}/!(${dirTmp})/**`, `${dir.src}${slugSub}/${slugSubSub}/`, {includeEmptyDirs: true});
					cpx.copy(`${dir.src}${dirTmp}/${dirTmp}/*.{html,php}`, `${dir.src}${slugSub}/${slugSubSub}/`);
				}
			}
		}
	}
}
