<script>
  import {  Heading, P, Button, Input, Img } from 'flowbite-svelte'
</script>

<div class="mt-5 container-fluid section-search">
  <div class="text-center">
    <Heading tag="h1" class="mb-4" customSize="text-4xl font-extrabold md:text-5xl lg:text-6xl">Search Doctor, Make an Appointment</Heading>
    <P class="mb-6 text-lg lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400 text-center">Discover the best doctors, clinic & hospital the city nearest to you.</P>
  </div>
  <div class="flex justify-center container-fluid search-box">
    <form>
      <div class="search-location">
        <Input type="text" id="location" placeholder="Search location" required/>
      </div>
      <div class="search-info">
        <Input type="text" id="type" placeholder="Speciality" required/>
      </div>
      <Button class="search-btn">Search</Button>
    </form>
  </div>
  <div class="flex justify-center">
    <Img src="/images/search-bg.png" size="max-w-full" alt="sample 1"/>
  </div>
</div>