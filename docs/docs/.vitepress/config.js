module.exports = {
  title: 'YouTube Live Embed Plugin Documentation',
  description: 'Documentation for the YouTube Live Embed plugin',
  base: '/docs/youtubeliveembed/',
  lang: 'en-US',
  head: [
    ['meta', {content: 'https://github.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://twitter.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://youtube.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://www.facebook.com/newyorkstudio107', property: 'og:see_also',}],
  ],
  themeConfig: {
    repo: 'nystudio107/craft-youtubeliveembed',
    docsDir: 'docs/docs',
    docsBranch: 'develop',
    algolia: {
      appId: '9WVGU2S0Q9',
      apiKey: 'f3e0e6146b913085e5b5f9fc8408d4a6',
      indexName: 'nystudio107-youtubeliveembed'
    },
    editLinks: true,
    editLinkText: 'Edit this page on GitHub',
    lastUpdated: 'Last Updated',
    sidebar: 'auto',
  },
};
