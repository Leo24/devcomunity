module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        watch: {
            sass: {
                files: ['css/sass/*.scss', 'css/sass/plugins/*.scss', 'css/sass/importer.scss', 'css/sass/buddypress/*.scss'],
                tasks: ['sass:dist']
            }
        },
        sass: {
            options: {
                sourceMap: true,
                outputStyle: 'nested',
                sourceComments: false
            },
            dist: {
                files: {
                    'style.css': 'css/sass/importer.scss',
                    'css/buddypress.css': 'css/sass/buddypress.scss'
                }
            }
        }
    });
    grunt.registerTask('default', ['sass:dist', 'watch']);
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
};
/*Dunhakdis Set-up*/
/*1.0 Use [npm install grunt --save-dev]*/
/*1.1 Use [npm install grunt-sass --save-dev]*/
/*1.2 Use [npm install grunt-contrib-watch --save-dev]*/
/*2.0 Use 'grunt' command to start a project*/

/* npm install grunt --save-dev; npm install grunt-sass --save-dev; npm install grunt-contrib-watch --save-dev */
/* Grunt */
