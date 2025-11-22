import { Box, Breadcrumb, BreadcrumbItem, BreadcrumbLink, Button, Input, Spacer } from '@chakra-ui/react';
import { router } from '@inertiajs/react';


export default function Header({showSearch=false,searchQuery,onSearchChange= ()=>{}}){

   return (
       <Box>
           <Breadcrumb fontWeight="medium" fontSize="md" h={100} backgroundColor={'blue.200'}>

                   <Button
                       color='white'
                       fontWeight='bold'
                       borderRadius='md'
                       bgGradient='linear(to-r, teal.500, green.500)'
                       _hover={{
                           bgGradient: 'linear(to-r, red.500, yellow.500)',
                       }}
                       m="10px"
                       onClick={() => router.visit(`/hotels`)}
                   >
                       Home
                   </Button>


               <Spacer />
               {showSearch && (
                  <>
                      <Input
                          placeholder='taper quelque chose à rechercher...'
                          size='md'
                          m={6}
                          backgroundColor={'whiteAlpha.600'}
                          width={500}
                          value={searchQuery}
                          onChange={(e)=>onSearchChange(e.target.value)}
                      />
                  </>
               )}

           </Breadcrumb>
       </Box>
   )
}
