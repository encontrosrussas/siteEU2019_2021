const mix = require('laravel-mix');
const path = require('path');
const tailwindcss = require('tailwindcss');
const autoprefixer = require('autoprefixer');
const purgecss = require('@fullhuman/postcss-purgecss');
const cssImport = require("postcss-import");
const cssNested = require("postcss-nested");

mix.setPublicPath('dist');

mix.js('src/js/app.js', 'dist/js');

mix.postCss('src/css/app.css', 'dist/css')
    .options({
        processCssUrls: false,
        postCss: [
            cssImport(),
            cssNested(),
            autoprefixer(),
            tailwindcss('tailwind.config.js'),
            ...mix.inProduction() ? [
                purgecss({
                    content: ['../../../src/views/front/2020/**/*.html'],
                    defaultExtractor: content => content.match(/[\w-/:.]+(?<!:)/g) || [],
                    safelist: {
                        greedy: [/timeline/],
                    }
                })
            ] : [],
        ],
    });