module.exports = function(grunt) {

	grunt.initConfig({

		"sass": {

			dist: {

				files: { "assets/css/style.css": "assets/scss/main.scss" }

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
  					"assets/scss/**/*.scss"

  				],

  				tasks: [

  					"styles"

  				],

  				options: { event: [ "all" ], }

  			}
  			
		}

	});

	grunt.loadNpmTasks("grunt-contrib-sass");
	grunt.loadNpmTasks("grunt-contrib-cssmin");

	grunt.loadNpmTasks("grunt-contrib-watch");

	grunt.registerTask("default", ["styles"]);

	grunt.registerTask("styles", ["sass:dist", "cssmin:dist"]);

	grunt.registerTask("auto", ["watch:dist"]);

}