                    <div class="container mt-3">
                        <h2>Play Videos</h2>
                        <div class="card">

                            <div>
                                <video id="myVideo" width="100%" height="500" controls>
                                    <source src="videos/mov_bbb.mp4" type="video/mp4">
                                    <source src="videos/mov_bbb.ogg" type="video/ogg">
                                    Your browser does not support HTML5 video.
                                </video>
                            </div>

                            <br>


                            <iframe width="100%" height="500"
                                src="https://www.youtube.com/embed/iPtCgeMJGsE?si=ZCLY90xJsROqpqLz"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

                        </div>



                        <style>
                            .video-container {
                                width: 100%;
                                max-width: 100%;
                                overflow: hidden;
                                position: relative;
                                padding-top: 56.25%;
                                /* 16:9 Aspect Ratio */
                            }

                            .video-container iframe {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                            }
                        </style>