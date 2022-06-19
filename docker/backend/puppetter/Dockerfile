FROM node:14-slim

RUN apt-get update \
    && apt-get install -yq gconf-service libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 \
    libexpat1 libfontconfig1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 \
    libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 \
    libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 \
    ca-certificates fonts-liberation libappindicator1 libnss3 lsb-release xdg-utils wget \
    xvfb x11vnc x11-xkb-utils xfonts-100dpi xfonts-75dpi xfonts-scalable xfonts-cyrillic x11-apps \
    --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*


WORKDIR /puppetter

COPY /puppetter/package.json /puppetter
RUN npm i
COPY  /puppetter /puppetter

#RUN npm init -y &&  \
# puppeteer-stream
# Add user so we don't need --no-sandbox.
# same layer as npm install to keep re-chowned files from using up several hundred MBs more space

#группа node существует
#RUN adduser --system --uid 1001

RUN mkdir -p /home/node/Downloads \
    && mkdir /tmp/.X11-unix \
    && chmod 1777 /tmp/.X11-unix \
    && chown root /tmp/.X11-unix \
    && chown -R node:node /home/node \
    && chown -R node:node /puppetter \
    && chmod -R 777 /puppetter/pdf \
    && chown -R node:node ./node_modules \
    && chown -R node:node ./package.json \
    && chown -R node:node ./package-lock.json

RUN mkdir /usr/local/sbin/chrome-devel-sandbox \
    && chown root:root /usr/local/sbin/chrome-devel-sandbox \
    && chmod 4755 /usr/local/sbin/chrome-devel-sandbox \
    && export CHROME_DEVEL_SANDBOX=/usr/local/sbin/chrome-devel-sandbox

# Start server on port 3000
EXPOSE 3000:3000
ENV PORT=3000

# Creating Display
ENV DISPLAY :99
WORKDIR /puppetter
USER node
# Start script on Xvfb
# [ -f /tmp/.X100-lock ] &&  rm $FILE || 'file not found'
CMD Xvfb :99 -screen 0 1024x768x16 & npm start


