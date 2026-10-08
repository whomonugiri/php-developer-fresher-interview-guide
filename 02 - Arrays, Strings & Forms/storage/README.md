# Private local demo storage

Question 26 creates `uploads/` if needed and saves PDFs with random names here.
This directory must remain outside the web server document root. Uploaded PDFs
are untrusted, never executed or served by the teaching router, and ignored by
Git. Delete your own demo files after testing. Do not use real personal documents.
