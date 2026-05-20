
 # wordpress-devsecops

  Small DevSecOps lab: a deliberately vulnerable WordPress deployment is
  scanned with WPScan, hardened across the Dockerfile, PHP, Apache,
  .htaccess, and wp-config layers, then re-scanned to verify the fix.

  The whole flow runs as a three-job GitHub Actions pipeline
  (`scan` -> `build-hardened` -> `rescan`) on every push to `main`.
  Both scan results live in `scans/` as evidence.

  The hardened image is published to Docker Hub:
  `docker pull darius2525/wordpress-hardened:hardened`