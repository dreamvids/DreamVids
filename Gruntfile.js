module.exports = function(grunt) {

	grunt.initConfig({

		"concat": {

			dist: {

				src: [

					"assets/scripts/main.js",

					"assets/scripts/libs/**/*.js",

					"assets/scripts/Core/**/*.js",

					"assets/scripts/components/*/main.js",
					"assets/scripts/components/**/*.js",

					"assets/scripts/scripts/**/*.js",

					"assets/scripts/**/*.js"

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

		"concurrent": {

			auto: ["auto-scripts", "auto-style"],

            options: {

            	logConcurrentOutput: true

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

  			},

  			scripts: {

  				files: [

  					"Gruntfile.js",
  					"assets/scripts/**/*.js"

  				],

  				tasks: [

  					"scripts"

  				],

  				options: { event: [ "all" ], }

  			},

  			style: {

  				files: [

  					"Gruntfile.js",
  					"assets/style/**/*.scss"

  				],

  				tasks: [

  					"styles"

  				],

  				options: { event: [ "all" ], }

  			}
  			
		}

	});

	grunt.loadNpmTasks("grunt-contrib-concat");
	grunt.loadNpmTasks("grunt-contrib-uglify");

	grunt.loadNpmTasks("grunt-sass");
	grunt.loadNpmTasks("grunt-contrib-cssmin");

	grunt.loadNpmTasks("grunt-contrib-watch");
	grunt.loadNpmTasks("grunt-concurrent");

	grunt.registerTask("default", ["scripts", "styles"]);

	grunt.registerTask("scripts", ["concat:dist", "uglify:dist"]);
	grunt.registerTask("styles", ["sass:dist", "cssmin:dist"]);

	grunt.registerTask("auto", ["concurrent:auto"]);
	grunt.registerTask("dev", ["auto"]);
	grunt.registerTask("d", ["auto"]);
	grunt.registerTask("auto-scripts", ["watch:scripts"]);
	grunt.registerTask("auto-style", ["watch:style"]);

}
