FROM rocker/shiny:3.6.3

ARG JOBEIP

COPY shiny-server.sh /usr/bin/shiny-server.sh

COPY PrimerIzboljsav /srv/shiny-server/PrimerIzboljsav
COPY OsnovnoDelovanje /srv/shiny-server/OsnovnoDelovanje

COPY libraries /home/libraries

RUN apt-get update && apt-get install -y \
    libv8-dev \
    build-essential \
    libcurl4-gnutls-dev \
    libxml2-dev \
    libssl-dev 

# Download and install shiny server and R packages
RUN R -e "install.packages(c('devtools', 'unix'), dependencies = TRUE)" && \
    R -e "devtools::install_github('tadson10/learnr', dependencies = TRUE)" && \
    chmod +x /usr/bin/shiny-server.sh && \
    # chown shiny:shiny -R /srv/shiny-server/ && \
    # chmod 755 -R /srv/shiny-server/ && \
    sed -i "s/#JOBE_SERVER_IP#/$JOBEIP/g" /srv/shiny-server/PrimerIzboljsav/PrimerIzboljsav.Rmd && \
    sed -i "s/#JOBE_SERVER_IP#/$JOBEIP/g" /srv/shiny-server/PrimerIzboljsav/PrimerIzboljsav.html

EXPOSE 3838