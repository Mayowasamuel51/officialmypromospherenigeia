// import { SitemapStream, streamToPromise } from 'sitemap';
// import { writeFileSync } from 'fs';



// const links = [
//   { url: '/2', changefreq: 'daily', priority: 1.0 },
//   { url: '/3', changefreq: 'daily', priority: 1.0 },
//   { url: '/4', changefreq: 'daily', priority: 1.0 },
//   { url: '/55', changefreq: 'daily', priority: 1.0 },
//   { url: '/33', changefreq: 'daily', priority: 1.0 },
//   { url: '/22', changefreq: 'daily', priority: 1.0 }, 
//   { url: '/24', changefreq: 'daily', priority: 1.0 },
//   { url: '/77', changefreq: 'daily', priority: 1.0 },
//   { url: '/32', changefreq: 'daily', priority: 1.0 },
//   { url: '/45', changefreq: 'daily', priority: 1.0 },

//   {
//     url: 'https://www.mypromosphere.com/sellervideo/9',
//     changefreq: 'daily',
//     priority: 1.0,
//     video: {
//       thumbnailUrl: 'https://www.mypromosphere.com/images/photo.png',
//       title: 'Video Title 1',
//       description: "Three beds apartment off freedom way, 24 hours light, Free internet WiFi,Housekeeping, Etc",
//       contentUrl: 'https://www.mypromosphere.com/sellervideo/9',
//       playerUrl: 'https://www.mypromosphere.com/sellervideo/9',
//       duration: 120,
//       publicationDate: '2024-01-01T12:00:00+00:00',
//     },
//   },

//   {
//     url: 'https://www.mypromosphere.com/sellervideo/8',
//     changefreq: 'daily',
//     priority: 1.0,
//     video: {
//       thumbnailUrl: 'https://www.mypromosphere.com/images/photo.png',
//       title: 'Video Title 1',
//       description: "This lovely 3 bedroom apartment with basic amenities is available from today till 27th December.📍Location: off Freedom way, Lekki Phase 1",
//       contentUrl: 'https://www.mypromosphere.com/sellervideo/8',
//       playerUrl: 'https://www.mypromosphere.com/sellervideo/8',
//       duration: 120,
//       publicationDate: '2024-01-01T12:00:00+00:00',
//     },
//   },

//   { url: '/mypromotalk', changefreq: 'daily', priority: 1.0 },
//   { url: '/mypromotweet', changefreq: 'daily', priority: 1.0 },


//   // {url:'/mypromotalk/62' ,changefreq:'daily' , priority:1.0},
//   // {url:'/mypromotalk/51' ,changefreq:'daily' , priority:1.0},
//   {url:'/mypromotalk/49' ,changefreq:'daily' , priority:1.0},
//   // {url:'/mypromotalk/51' ,changefreq:'daily' , priority:1.0},
//   // {url:'/mypromotalk/1' ,changefreq:'daily' , priority:1.0},
//   // {url:'/mypromotalk/2' ,changefreq:'daily' , priority:1.0},
//   {url:'/mypromotalk/4' ,changefreq:'daily' , priority:1.0},
//   // {url:'/mypromotalk/5' ,changefreq:'daily' , priority:1.0},
//   // {url:'/mypromotalk/4' ,changefreq:'daily' , priority:1.0},
//   // {url:'/mypromotalk/53' ,changefreq:'daily' , priority:1.0},
//   {url:'/mypromotalk/77' ,changefreq:'daily' , priority:1.0},
//   {url:'/mypromotalk/53' ,changefreq:'daily' , priority:1.0},
// ];

// const generateSitemap = async () => {
//   const sitemap = new SitemapStream({ hostname: 'https://www.mypromosphere.com' });

//   try {
//     links.forEach((link) => sitemap.write(link));
//     sitemap.end();

//     const data = await streamToPromise(sitemap);

//     writeFileSync('./public/sitemap.xml', data.toString());
//     console.log('Sitemap generated successfully!');
//   } catch (error) {
//     console.error('Error generating sitemap:', error);
//   }
// };

// generateSitemap();
