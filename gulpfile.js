var gulp = require("gulp");

var fs = require("fs");

if (fs.existsSync("./dev.json")) {

	var devjson = require("./dev.json")

}

else {

	var devjson = {};

}

var rename = require("gulp-rename");

var sass = require("gulp-sass"),
	minify = require("gulp-minify-css");

var concat = require("gulp-concat"),
	uglify = require("gulp-uglify"),
	react = require("gulp-react");

var browserSync = require("browser-sync");

gulp.task("style", function () {

	return gulp.src("assets/style/main.scss")
		.pipe(sass())
		.pipe(rename("style.css"))
		.pipe(gulp.dest("assets/css/"))

		.pipe(minify())
		.pipe(rename("style.min.css"))
		.pipe(gulp.dest("assets/css/"));

});

gulp.task("scripts", function () {

	return gulp.src([

			"assets/scripts/main.js",

			"assets/scripts/libs/**/*.js",

			"assets/scripts/Core/**/*.js",

			"assets/scripts/components/*/main.js",
			"assets/scripts/components/**/*.js",

			"assets/scripts/scripts/**/*.js",

			"assets/scripts/**/*.js"

		])
		.pipe(concat("script.js"))
		.pipe(gulp.dest("assets/js/"))

		.pipe(uglify())
		.pipe(rename("script.min.js"))
		.pipe(gulp.dest("assets/js/"));

});

gulp.task("browser-sync", function() {

	if (devjson.browserSyncProxy) {

		browserSync.init([

			"assets/js/*.js",
			"assets/css/*.css"
		
		], {

			proxy: devjson.browserSyncProxy

		});

	}

	else {

		console.info("No `browserSyncProxy` defined in `dev.json`");

	}

});

gulp.task("default", ["scripts", "style", "browser-sync"], function() {

	gulp.watch("assets/scripts/**/*.js", ["scripts"]);

	gulp.watch("assets/style/**/*.scss", ["style"]);

});