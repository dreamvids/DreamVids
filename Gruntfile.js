module.exports = function(grunt) {

	grunt.initConfig({

		"concat": {

			dist: {

				src: [

					"assets/scripts/intro.js",
					"assets/scripts/main.js",

					"assets/scripts/Events/main.js",
					"assets/scripts/Events/**/*.js",
					
					"assets/scripts/Core/**/*.js",

					"assets/scripts/Element/main.js",
					"assets/scripts/Element/**/*.js",

					"assets/scripts/Components/main.js",
					"assets/scripts/Components/*.js",
					"assets/scripts/Components/*/main.js",
					"assets/scripts/Components/**/*.js",

					"assets/scripts/Emitters/*/main.js",
					"assets/scripts/Emitters/**/*.js",

					"assets/scripts/**/*.js",
					"assets/scripts/outro.js"

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

		"usebanner": {

		    dist: {

		      	options: {

		        	position: "top",
		        	linebreak: true,

		        	banner: "/**\n"
		        	      + " * ATTENTION ! IL EST INUTILE DE MODIFIER CE FICHIER\n"
		        		  + " * CAR  VOS  MODIFICATIONS SERONT  ECRASÉES  PAR  LE\n"
		        		  + " * PROCHAIN COMMIT\n"
		        		  + " *\n"
		        		  + " * Pour modifier le contenu de ce fichier, il faut\n"
		        		  + " * modifier ses sources qui se situent soit dans\n"
		        		  + " * le dossier `style`, le dossier `scripts` selon\n"
		        		  + " * vos besoin. Il faut ensuite compiler à l'aide du\n"
		        		  + " * lanceur de taches Grunt. Pour plus d'infos,\n"
		        		  + " * rendez-vous dans le README du dossier `assets`\n"
		        		  + " */"

		      	},

		      	files: {

		        	src: [ "assets/css/style.css", "assets/js/script.js" ]

		      	}
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

	grunt.loadNpmTasks("grunt-banner");

	grunt.loadNpmTasks("grunt-contrib-concat");
	grunt.loadNpmTasks("grunt-contrib-uglify");

	grunt.loadNpmTasks("grunt-contrib-sass");
	grunt.loadNpmTasks("grunt-contrib-cssmin");

	grunt.loadNpmTasks("grunt-contrib-watch");
	grunt.loadNpmTasks("grunt-concurrent");

	grunt.registerTask("default", ["scripts", "styles"]);

	grunt.registerTask("scripts", ["concat:dist", "uglify:dist", "usebanner:dist"]);
	grunt.registerTask("styles", ["sass:dist", "cssmin:dist", "usebanner:dist"]);

	grunt.registerTask("auto", ["concurrent:auto"]);
	grunt.registerTask("auto-scripts", ["watch:scripts"]);
	grunt.registerTask("auto-style", ["watch:style"]);

}