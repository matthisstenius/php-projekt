module.exports = function(grunt) {
	grunt.initConfig({
		copy: {
			build: {
				cwd: 'src',
				src: ['**'],
				dest: 'build',
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

		watch: {
			stylesheets: {
				files: 'src/public/sass/main.scss',
				tasks: ['compileSass']
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('build', ['copy']);
	grunt.registerTask('compileSass', ['sass']);
	grunt.registerTask('default', 'Watches the project for changes', ['watch']);
};