import {defineConfig} from 'vitepress'

export default defineConfig({
  title: 'YouTube Live Embed Plugin',
  description: 'Documentation for the YouTube Live Embed plugin',
  base: '/docs/youtubeliveembed/v3/',
  lang: 'en-US',
  head: [
    ['meta', {content: 'https://github.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://twitter.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://youtube.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://www.facebook.com/newyorkstudio107', property: 'og:see_also',}],
  ],
  themeConfig: {
    socialLinks: [
      {icon: 'github', link: 'https://github.com/nystudio107'},
      {icon: 'twitter', link: 'https://twitter.com/nystudio107'},
    ],
    logo: '/img/plugin-logo.svg',
    editLink: {
      pattern: 'https://github.com/nystudio107/craft-youtubeliveembed/edit/develop/docs/docs/:path',
      text: 'Edit this page on GitHub'
    },
    algolia: {
      appId: '9WVGU2S0Q9',
      apiKey: 'f3e0e6146b913085e5b5f9fc8408d4a6',
      indexName: 'nystudio107-youtubeliveembed'
    },
    lastUpdatedText: 'Last Updated',
    sidebar: [],
    nav: [
      {text: 'Home', link: 'https://nystudio107.com/plugins/youtube-live-embed'},
      {text: 'Store', link: 'https://plugins.craftcms.com/youtubeliveembed'},
      {text: 'Changelog', link: 'https://nystudio107.com/plugins/youtube-live-embed/changelog'},
      {text: 'Issues', link: 'https://github.com/nystudio107/craft-youtubeliveembed/issues'},
      {
        text: 'v3', items: [
          {text: 'v4', link: 'https://nystudio107.com/docs/youtubeliveembed/'},
          {text: 'v3', link: '/'},
        ],
      },
    ]
  },
});
