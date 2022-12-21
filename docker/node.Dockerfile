FROM node:lts-alpine

# install simple http server for serving static content
RUN npm install -g http-server

# make the 'app' folder the current working directory
WORKDIR /app/vuefood

# copy both 'package.json' and 'package-lock.json' (if available)
COPY front/vuefood/package*.json .

# install project dependencies
RUN npm install

# copy project files and folders to the current working directory (i.e. 'app' folder)
COPY /front .

# build app for production with minification
#RUN npm run serve

EXPOSE 8080
EXPOSE 8081
CMD [ "http-server", "dist" ]