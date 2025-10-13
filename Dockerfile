# Base image
FROM node:18

# Set working directory
WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy all source
COPY . .

# Expose port (giống trong .env)
EXPOSE 3000

# Start the app
CMD ["npm", "start"]
