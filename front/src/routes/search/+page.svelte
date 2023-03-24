<script>
  import {Breadcrumb, BreadcrumbItem, Button, Checkbox, Img, Rating, Select} from 'flowbite-svelte';
  import {Datepicker} from 'flowbite-svelte';
  import {onMount} from "svelte";
  import {users} from '$lib/stores/user/store';

  let sorting = [
    {value:"1", name: "Rating"},
    {value:"2", name: "Popular"},
    {value:"3", name: "Latest"},
  ];

  onMount(() => {
    fetch('http://localhost:90/api/professionals')
        .then(response => response.json())
        .then(json => {
          console.log(json.items)
          users.set(json.items);
        });
  });
</script>

<div class="mt-5 container-fluid">
  <div class="breadcrumb-bar">
    <div class="container-fluid">
      <div class="row align-items-center">
      <div class="col-md-8 col-12">
        <Breadcrumb aria-label="Default breadcrumb example" class="justify-left">
          <BreadcrumbItem href="/" home>Home</BreadcrumbItem>
          <BreadcrumbItem>Search</BreadcrumbItem>
        </Breadcrumb>
        <h2 class="breadcrumb-title">2245 matches found for : Dentist In Bangalore</h2>
      </div>
      <div class="col-md-4 col-12 d-md-block d-none">
        <div class="sort-by">
          <span class="sort-title">Sort by</span>
          <span class="sortby-fliter">
                <Select items="{sorting}" bind:value="{sorting}"></Select>
            </span>
        </div>
      </div>
      </div>
    </div>
  </div>

  <!-- Page Content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">

          <!-- Search Filter -->
          <div class="card search-filter">
            <div class="card-header">
              <h4 class="card-title mb-0">Search Filter</h4>
            </div>
            <div class="card-body">
              <div class="filter-widget">
                <div class="cal-icon">
                  <input type="text" class="form-control datetimepicker" placeholder="Select Date">
                </div>
              </div>
              <div class="filter-widget">
                <h4>Gender</h4>
                <div>
                  <Checkbox checked>Male Doctor</Checkbox>
                </div>
                <div>
                  <Checkbox>Female Doctor</Checkbox>
                </div>
              </div>
              <div class="filter-widget">
                <h4>Select Specialist</h4>
                <div>
                  <Checkbox>Urology</Checkbox>
                </div>
                <div>
                  <Checkbox>Neurology</Checkbox>
                </div>
                <div>
                  <Checkbox>Dentist</Checkbox>
                </div>
                <div>
                  <Checkbox>Orthopedic</Checkbox>
                </div>
                <div>
                  <Checkbox>Cardiologist</Checkbox>
                </div>
              </div>
              <div class="btn-search">
                <Button class="btn btn-block">Search</Button>
              </div>
            </div>
          </div>
          <!-- /Search Filter -->

        </div>

        <div class="col-md-12 col-lg-8 col-xl-9">

          <!-- Doctor Widget -->
          {#each $users as user}
          <div class="card">
            <div class="card-body">
              <div class="doctor-widget">
                <div class="doc-info-left">
                  <div class="doctor-img">
                    <a href="doctor-profile.html">
                      <Img src="/images/doctor/doctor-thumb-01.jpg" class="img-fluid" alt="User Image" />
                    </a>
                  </div>
                  <div class="doc-info-cont">
                    <h4 class="doc-name"><a href="doctor-profile.html">Dr. {user.firstName} {user.lastName}</a></h4>
                    <p class="doc-speciality">MDS - Periodontology and Oral Implantology, BDS</p>
                    <h5 class="doc-department"><Img src="/images/specialities/specialities-05.png" class="img-fluid" alt="Speciality" />Dentist</h5>
                    <div class="rating">
                      <Rating total={5} rating={4.66} ceil><p slot="text">(17)</p></Rating>
                    </div>
                    <div class="clinic-details">
                      <p class="doc-location"><i class="fas fa-map-marker-alt"></i> Florida, USA</p>
                    </div>
                    <div class="clinic-services">
                      <span>Dental Fillings</span>
                      <span> Whitneing</span>
                    </div>
                  </div>
                </div>
                <div class="doc-info-right">
                  <div class="clini-infos">
                    <ul>
                      <li><i class="far fa-thumbs-up"></i> 98%</li>
                      <li><i class="far fa-comment"></i> 17 Feedback</li>
                      <li><i class="fas fa-map-marker-alt"></i> Florida, USA</li>
                      <li><i class="far fa-money-bill-alt"></i> $300 - $1000 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i> </li>
                    </ul>
                  </div>
                  <div class="clinic-booking">
                    <a class="view-pro-btn" href="doctor-profile.html">View Profile</a>
                    <a class="apt-btn" href="booking.html">Book Appointment</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /Doctor Widget -->
          {/each}

          <div class="load-more text-center">
            <a class="btn btn-primary btn-sm" href="javascript:void(0);">Load More</a>
          </div>
        </div>
      </div>

    </div>

  </div>
  <!-- /Page Content -->
</div>
