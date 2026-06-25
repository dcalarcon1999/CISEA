<!DOCTYPE html>
<html lang="es">

     <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
          <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
          <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
          <title> SICEA - Panel de Evidencias </title>
          <style>
               /* Estilos base para simular tu menú lateral */
               .side_menu { background-color: #1a252f; color: white; min-height: 100vh; padding: 20px; }
               .list_item a { color: #ecf0f1; text-decoration: none; display: block; padding: 10px 0; }
               .list_item.active a { color: #f1c40f; font-weight: bold; }
               .navbar { background-color: #2c3e50; color: white; padding: 15px; }
          </style>
     </head>
   
     <body>
          <div class="container-fluid">
               <div class="row">
                    <div class="col-md-3 side_menu">
                         <div class="text-center pb-3">
                              <h4 class="mt-3 text-warning">SICEA</h4>
                              <p class="small text-muted">Control de Evidencia Audiovisual</p>
                              <hr style="border-color: #34495e;">
                              <p style="color: #fff; font-size: 14px;">CARLOS DANIEL ALARCÓN LAGOS</p>
                         </div>
                         <hr style="border-color: #34495e;">

                         <ul class="list-unstyled list_load"> 
                              <li class="list_item active"><a href="#evidencias"><i class="fas fa-folder-open mr-2"></i>Módulo Evidencias</a></li>
                              <hr style="border-color: #34495e;">
                              <li class="list_item"><a href="#custodia"><i class="fas fa-shield-alt mr-2"></i>Cadena de Custodia</a></li>
                              <hr style="border-color: #34495e;">
                              <li class="list_item"><a href="#reportes"><i class="fas fa-file-chart-line mr-2"></i>Reportes e Hitos</a></li>
                              <hr style="border-color: #34495e;">
                              <li class="list_item"><a href="/logout"><i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión</a></li>
                         </ul>
                    </div>

                    <div class="col-md-9 p-0">
                         <nav class="navbar d-flex justify-content-between">
                              <h3>Módulo Gestión de Evidencias (Anexo N°1)</h3>
                              <p class="mb-0" id="psw" style="color: #f1c40f;">Entorno de Desarrollo Seguro</p>
                         </nav>

                         <div class="container mt-4">
                              <div class="row mb-3">
                                   <div class="col-md-4">
                                        <a class="btn btn-primary btn-sm" href="#" role="button"><i class="fas fa-plus mr-1"></i> Registrar Nueva Evidencia</a>
                                   </div>
                                   <div class="col-md-4">	
                                        <form class="form-inline justify-content-end">	
                                             <input type="text" class="form-control form-control-sm mr-2" required placeholder="Buscar por RUC o RIT">
                                             <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
                                        </form>	
                                   </div>
                                   <div class="col-md-4">
                                        <form class="form-inline justify-content-end">
                                             <input class="form-control form-control-sm mr-1" type="date" required>	
                                             <input class="form-control form-control-sm mr-1" type="date" required>
                                             <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                                        </form>
                                   </div>
                              </div>

                              <div class="table-responsive">
                                   <table class="table table-hover shadow-sm table-sm" id="table">
                                        <thead class="thead-dark">
                                             <tr>
                                                  <th scope="col">ID Evidencia</th>
                                                  <th scope="col">Fecha Ingreso</th>
                                                  <th scope="col">Identificador Judicial (RUC/RIT)</th>
                                                  <th scope="col">Descripción / Estado Custodia</th>
                                                  <th scope="col" class="text-center">Acciones</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                  <td><strong>EVID-001</strong></td>
                                                  <td>2026-06-24</td>
                                                  <td><span class="badge badge-info">RUC: 240012345-K</span></td>
                                                  <td>Video de respaldo de fijación fotográfica de sitio del suceso - Integridad Verificada</td>
                                                  <td class="text-center">
                                                       <a href="#" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i> Gestionar</a>
                                                  </td>
                                             </tr>	
                                             <tr>
                                                  <td><strong>EVID-002</strong></td>
                                                  <td>2026-06-23</td>
                                                  <td><span class="badge badge-secondary">RIT: O-45-2026</span></td>
                                                  <td>Audio de entrevista e inspección de registro técnico institucional.</td>
                                                  <td class="text-center">
                                                       <a href="#" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i> Gestionar</a>
                                                  </td>
                                             </tr>	
                                        </tbody>
                                   </table>
                              </div>	
                              <div>
                                   <p class="text-muted small">Mostrando 2 registros del repositorio de evidencias institucional SICEA</p>
                              </div>
                         </div>
                    </div>
               </div>
          </div>

          <div class="footer bg-light text-center py-2 fixed-bottom border-top">
               <p class="mb-0 text-muted small">SICEA — Dirección de Tecnologías de la Información y las Comunicaciones | Portafolio de Proyectos 2026</p>			
          </div>

          <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>  
     </body>
</html>