# Use an official Node.js runtime as the base image
FROM node:alpine

# Set the working directory in the container
WORKDIR /usr/src/app

# Copy package.json and package-lock.json to the working directory
COPY ./frontend/package*.json ./

# Install the dependencies
RUN npm install

# Copy the rest of the application code to the working directory
COPY ./frontend/ ./


# Expose a port
EXPOSE 3000

# Define the command to run your application in development mode
CMD [ "npm", "run", "dev" ]