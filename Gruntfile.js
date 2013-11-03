module.exports = function(grunt) {
	grunt.initConfig({
		copy: {
			build: {
				expand: true,
				cwd: 'src',
				src: ['**', '!public/**', '../index.php'],
				dest: 'build/php-projekt/src'
			},

			copyFont: {
				expand: true,
				cwd: 'src',
				src: ['/font/**'],
				dest: 'build/php-projekt/src/public/'
			}
		},

		sass: {
			dist: {
				files: {
					'src/public/css/main.css': 'src/public/sass/main.scss'
				}
			}	
		},

		cssmin: {
			minifyCSS: {
				files: {
					'build/php-projekt/src/public/css/main.css': 'src/public/css/*.css'
				}
			}
		},

		imagemin: {
			minifyImg: {
				files: [{
					expand: true,
					cwd: 'src',
					src: ['public/img/*.{png,jpg,gif}'],
					dest: 'build/php-projekt/src/public/img'
				}]
			}
		},

		watch: {
			stylesheets: {
				files: 'src/public/sass/*.scss',
				tasks: ['compileSass'],
				options: {
					livereload: true
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-imagemin');

	grunt.registerTask('build', ['copy', 'minifyCSS', 'minifyImg', 'copyFont']);
	grunt.registerTask('minifyCSS', ['cssmin']);
	grunt.registerTask('minifyImg', ['imagemin']);
	grunt.registerTask('compileSass', ['sass']);
	grunt.registerTask('copyFont', ['copy']);
	grunt.registerTask('default', 'Watches the project for changes', ['watch']);
};