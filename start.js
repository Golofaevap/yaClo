const fs = require("fs");
const path = require("path");

const rootFolder = "./";
const resultsFolder = "./results";

if (!fs.existsSync(resultsFolder)) {
    console.log("no result dir ", rootFolder);
    return;
}
if (!fs.existsSync(path.join(rootFolder, "current.json"))) {
    console.log("current.json does not exist");
    return;
}

var files = fs.readdirSync(resultsFolder);
if (files.length) {
    console.log("Results folder is not empty. Clear. And Try Again", files);
    return;
}

const current = require("./current.json");
for (let i in current) {
    const row = current[i];
    const newPath = path.join(resultsFolder, row.name);
    if (fs.existsSync(newPath)) {
        console.log("file with this id already exist", row.name);
        continue;
    }
    fs.mkdirSync(newPath);

    // console.log(oldFolFile, newFolFile);
    try {
        const phpFile = fs.readFileSync("source.php", "utf8");
        var result = phpFile.replace("{<replace>}", row.name);
        result = result.replace("{[money]}", row.moneyPage);
        result = result.replace("{[safe]}", row.safePage);
        fs.writeFileSync(path.join(newPath, "index.php"), result, "utf8");
    } catch (error) {
        console.log(error);
    }
}
