module.exports = function(grunt) {

	grunt.initConfig({

		"concat": {

			dist: {

				src: [

					"assets/scripts/Core/main.js",

					"assets/scripts/Utils/librairy/**/*.js",
					"assets/scripts/Utils/**/*.js",

					"assets/scripts/**/*.js",

				],

				dest: "assets/js/script.js",

			}

		},

		"uglify": {

			dist: {

				files: { "assets/js/script.min.js": ["assets/js/script.js"] }

			}

		},

		"sass": {

			dist: {

				files: { "assets/css/style.css": "assets/style/main.scss" }

			}

		},

		"cssmin": {

			dist: {

				files: { "assets/css/style.min.css": [ "assets/css/style.css" ] }

			}

		},

		"watch": {

			dist: {

  				files: [

  					"Gruntfile.js",
  					"assets/scripts/**/*.js",
  					"assets/style/**/*.scss"

  				],

  				tasks: [

  					"scripts",
  					"styles"

  				],

  				options: { event: [ "all" ], }

  			}
  			
		}

	});

	grunt.loadNpmTasks("grunt-contrib-concat");
	grunt.loadNpmTasks("grunt-contrib-uglify");

	grunt.loadNpmTasks("grunt-contrib-sass");
	grunt.loadNpmTasks("grunt-contrib-cssmin");

	grunt.loadNpmTasks("grunt-contrib-watch");

	grunt.registerTask("default", ["scripts", "styles"]);

	grunt.registerTask("scripts", ["concat:dist", "uglify:dist"]);
	grunt.registerTask("styles", ["sass:dist", "cssmin:dist"]);

	grunt.registerTask("auto", ["watch:dist"]);

}