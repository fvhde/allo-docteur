FROM node:18-alpine
WORKDIR /app
ENV HOST="0.0.0.0"
ENV PORT="5173"
EXPOSE 5173
COPY . .
RUN npm install
ENTRYPOINT ["npm", "run", "dev"]
