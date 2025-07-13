
<aside class="probootstrap-aside js-probootstrap-aside active ">
    <a href="#" class="probootstrap-close-menu js-probootstrap-close-menu d-md-none">
        Close
        <i class="fa fa-arrow-right"></i>
    </a>
    <div class="probootstrap-site-logo probootstrap-animate fadeInLeft probootstrap-animated"
        data-animate-effect="fadeInLeft">

        <a href="index.html" class="mb-2 d-block probootstrap-logo">MuseumCam</a>
        <p class="mb-0">Capture memories, share moments.</p>

    </div>
    <div class="probootstrap-overflow">
        <nav class="probootstrap-nav">
            <ul>
                <!-- LIVE ACCESS ONLY -->
                    <li class="probootstrap-animate fadeInLeft" data-mode="live">
                        <a href="#" id="receive-pictures">
                            <i class="fa fa-envelope mt-5 mr-2 mb-3"></i> Receive all my pictures
                        </a>
                    </li>
                    <li class="probootstrap-animate fadeInLeft" data-mode="live">
                        <a href="#" id="invite-friend-qr">
                          <i class="fa fa-mobile mr-2" style="font-size: 1.5em;"></i> Invite a friend (QR)
                        </a>
                      </li>

                <!-- LONG-TERM ACCESS ONLY -->
                <li class="probootstrap-animate fadeInLeft" data-mode="longterm">
                    <a href="#" id="invite-friend-email">
                        <i class="fa fa-user-plus mr-2 mb-3"></i> Invite a friend (Email)
                    </a>
                </li>
                <li class="probootstrap-animate fadeInLeft" data-mode="longterm">
                    <a href="{{route('photographer.download', ['albumId' => $album->id])}}">
                        <i class="fa fa-download mr-2"></i> Download all pictures
                    </a>
                </li>

            </ul>
        </nav>
        <footer class="probootstrap-aside-footer probootstrap-animate fadeInLeft probootstrap-animated"
            data-animate-effect="fadeInRight">
            <ul class="list-unstyled d-flex probootstrap-aside-social">
                <li><a href="https://github.com/kay1l" class="p-2"><i class="fa fa-github"></i></a></li>
                <li><a href="#" class="p-2"><span class="fa fa-instagram"></span></a></li>
                <li><a href="#" class="p-2"><span class="fa fa-linkedin"></span></a></li>
            </ul>
            <p>© 2025 . All Rights Reserved
            </p>
        </footer>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('[data-mode]').forEach(item => {
        if (item.getAttribute('data-mode') !== accessType) {
          item.style.display = 'none';
        } else {
          item.style.display = 'block';
        }
      });
    });
  </script>

