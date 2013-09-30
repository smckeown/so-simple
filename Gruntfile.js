module.exports = function(grunt) {
	'use strict';

	/**
	 * Load tasks.
	 */
	grunt.loadNpmTasks('grunt-contrib-compress');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		version: '<%= pkg.version %>',

		// Check JavaScript for errors.
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'assets/js/main.js'
			]
		},

		/**
		 * Watch sources files and compile when they're changed.
		 */
		watch: {
			js: {
				files: ['<%= jshint.all %>'],
				tasks: ['jshint']
			}
		},

		/**
		 * Archive the theme in the /release directory, excluding development
		 * and build related files.
		 *
		 * The zip archive will be named: theme-{{version}}.zip
		 */
		compress: {
			dist: {
				options: {
					archive: 'release/<%= pkg.slug %>-<%= version %>.zip'
				},
				files: [
					{
						src: [
							'**',
							'!node_modules/**',
							'!release/**',
							'!.jshintrc',
							'!Gruntfile.js',
							'!package.json'
						],
						dest: '<%= pkg.slug %>/'
					}
				]
			}
		}
	});

	/**
	 * Register default task.
	 */
	grunt.registerTask('default', [
		'jshint',
		'watch'
	]);

	/**
	 * Build a release.
	 *
	 * Defaults to the version set in package.json, but a specific version number can be passed
	 * as the first argument. Ex: grunt release:1.2.3
	 *
	 * The project is then zipped into an archive in the release directory,
	 * excluding unncessary source files in the process.
	 *
	 * @todo generate pot files
	 *       bump/verify version numbers
	 *       git tag, commit, and push
	 *       zip to release directory, cleaning source files in the process
	 *       push to remote server
	 */
	grunt.registerTask('release', function(arg1) {
		var pkg = grunt.file.readJSON('package.json');

		grunt.config.set('version', 0 === arguments.length ? pkg.version : arg1);
		grunt.task.run('jshint');
		grunt.task.run('compress:dist');
	});
};