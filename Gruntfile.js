module.exports = function(grunt) {

	grunt.initConfig({

<<<<<<< HEAD
=======
		"concat": {

			dist: {

				src: [

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

>>>>>>> dreamvids-2.0-dev
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
<<<<<<< HEAD
=======
  					"assets/scripts/**/*.js",
>>>>>>> dreamvids-2.0-dev
  					"assets/style/**/*.scss"

  				],

  				tasks: [

<<<<<<< HEAD
=======
  					"scripts",
>>>>>>> dreamvids-2.0-dev
  					"styles"

  				],

  				options: { event: [ "all" ], }

  			}
  			
		}

	});

<<<<<<< HEAD
=======
	grunt.loadNpmTasks("grunt-contrib-concat");
	grunt.loadNpmTasks("grunt-contrib-uglify");

>>>>>>> dreamvids-2.0-dev
	grunt.loadNpmTasks("grunt-contrib-sass");
	grunt.loadNpmTasks("grunt-contrib-cssmin");

	grunt.loadNpmTasks("grunt-contrib-watch");

<<<<<<< HEAD
	grunt.registerTask("default", ["styles"]);

=======
	grunt.registerTask("default", ["scripts", "styles"]);

	grunt.registerTask("scripts", ["concat:dist", "uglify:dist"]);
>>>>>>> dreamvids-2.0-dev
	grunt.registerTask("styles", ["sass:dist", "cssmin:dist"]);

	grunt.registerTask("auto", ["watch:dist"]);

}