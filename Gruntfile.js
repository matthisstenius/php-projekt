module.exports = function(grunt) {
	grunt.initConfig({
		copy: {
			build: {
				cwd: 'src',
				src: ['application/**', 'common/**', 'post/**', 'login/**', 'register/**'],
				dest: 'build/src',
				expand: true	
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
					'build/public/css/main.css': 'src/public/css/*.css'
				}
			}
		},

		imagemin: {
			minifyImg: {
				files: [{
					expand: true,
					cwd: 'src',
					src: ['public/img/*.{png,jpg,gif}'],
					dest: 'build/public/img'
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

	grunt.registerTask('build', ['copy', 'minifyCSS', 'minifyImg']);
	grunt.registerTask('minifyCSS', ['cssmin']);
	grunt.registerTask('minifyImg', ['imagemin']);
	grunt.registerTask('compileSass', ['sass']);
	grunt.registerTask('default', 'Watches the project for changes', ['watch']);
};