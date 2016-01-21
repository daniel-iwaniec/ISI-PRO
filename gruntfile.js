module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            options: {
                stripBanners: true
            },
            css: {
                src: [
                    'web/assets/bootstrap/dist/css/bootstrap.min.css',
                    'web/assets/bootstrap/dist/css/bootstrap-theme.min.css',
                    'web/app/css/css.css'
                ],
                dest: 'web/app.css'
            },
            js: {
                src: [
                    'web/assets/jQuery/dist/jquery.min.js',
                    'web/assets/bootstrap/dist/js/bootstrap.min.js',
                    'web/app/js/js.js'
                ],
                dest: 'web/app.js'
            }
        },
        cssmin: {
            target: {
                files: {
                    'web/app.min.css': ['web/app.css']
                }
            }
        },
        uglify: {
            build: {
                src: 'web/app.js',
                dest: 'web/app.min.js'
            }
        },
        less: {
            development: {
                options: {
                    compress: true,
                    yuicompress: true,
                    optimization: 2
                },
                files: {
                    'web/app/css/css.css': 'web/app/css/css.less'
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.registerTask('default', ['less', 'concat', 'cssmin', 'uglify']);
};
