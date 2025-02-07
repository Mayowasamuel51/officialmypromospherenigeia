

   {/* {data?.data.normalads.map((video) => (
            <SplideSlide>
              <div key={video.id}>
                <div className="cursor-pointer flex flex-col gap-2">
                  <div className="relative">
                    <video muted className="md:w-[300px] w-full aspect-square object-cover rounded-lg shadow-lg">
                      <source src={video.titlevideourl} type="video/mp4" />
                      Your browser does not support the video tag.
                    </video>
                    <div onClick={()=> handleVideoClick(video)} className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                      <FaRegCirclePlay size={50} color="#6A40F9" />
                    </div>
                  </div>
                  <Link to={`/sellervideo/${video.id}`} className={`font-semibold hover:text-lightblue duration-200 jost text-base ${darkMode ? "text-gray-600" : "text-black dark:text-black  font-semibold"}`}>{video.categories}</Link>
                </div>
              </div>
            </SplideSlide>
          ))} */}