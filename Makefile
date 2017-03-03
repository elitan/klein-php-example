all:
	python -mwebbrowser http://localhost:3000 &&\
	cd src &&\
	php -S localhost:3000 -file router.php
