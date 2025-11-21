import { usePage } from '@inertiajs/react';
import {
    Table,
    Thead,
    Tbody,
    Tr,
    Th,
    Td,
    TableContainer,
    Button,
    Text,
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    Image,
    Box,
    Link,
    Input,
    Spacer,
    AlertDialogFooter,
    AlertDialogBody,
    AlertDialogContent,
    AlertDialogOverlay,
    AlertDialogHeader,
    AlertDialog,
    useDisclosure,
    useToast,
} from '@chakra-ui/react';
import axios from 'axios';
import { router } from '@inertiajs/react';
import  { useEffect, useState,useRef } from 'react';

export default function Index({hotels:initialHotels}) {

    //toast bouton suppression d'hotel
    const { isOpen, onOpen, onClose } = useDisclosure()
    const cancelRef = useRef();
    const [selectedHotel,setSelectedHotel]=useState(null)
    const toast = useToast()


    //suivre l'état des hotels
    const [hotels,setHotels] = useState(initialHotels);


    useEffect(() => {
       setHotels(initialHotels);
    }, [initialHotels]);



    const deleteHotel = async (hotelId)=> {
        try{
            const response=await axios.delete(`http://localhost:8000/api/hotels/${hotelId}`);
            router.reload({only:['hotels']});
            /* toast de confirmation de suppression*/
            toast({
                title: response.data,
                status: 'success',
                position:'top-right',
                isClosable: true,
            })

        }catch(error){
            console.log(error)
            toast({
                title:`Erreur lors de la suppression de l'hôtel`,
                status: 'error',
                position:'top-right',
                isClosable: true,
            })
        }
    }

    return (
        <>
            <div>
                <Breadcrumb fontWeight="medium" fontSize="md" h={100} backgroundColor={'blue.200'}>
                    <BreadcrumbItem>
                        <BreadcrumbLink href="#">Home</BreadcrumbLink>
                    </BreadcrumbItem>
                    <BreadcrumbItem>
                        <BreadcrumbLink href="">Detail</BreadcrumbLink>
                    </BreadcrumbItem>
                    <Spacer />
                    <Input
                        placeholder='type something to search'
                        size='md'
                        m={6}
                        backgroundColor={'whiteAlpha.600'}
                        width={500}

                    />
                </Breadcrumb>
            </div>

            <div>
                <TableContainer>
                    <Table size="lg">
                        <Thead>
                            <Tr>
                                <Th>Image</Th>
                                <Th>Name</Th>
                                <Th>Description</Th>
                                <Th>Capacité Maximale</Th>
                                <Th>Modification</Th>
                                <Th>Suppression</Th>
                            </Tr>
                        </Thead>
                        <Tbody>
                            {hotels.map((hotel) => (
                                <Tr key={hotel.id}>
                                    <Td>
                                        <Link href={`/hotels/${hotel.id}`}>
                                            <Button m={5}>
                                                Detail
                                            </Button>
                                        </Link>
                                        <Image
                                            borderRadius='full'
                                            boxSize='100px'
                                            objectFit='cover'
                                            src={hotel.firstPictures}
                                            alt=''
                                        />
                                    </Td>
                                    <Td>{hotel.name}</Td>
                                    <Td>
                                        <Box w="200px" overflow="hidden">
                                            <Text isTruncated noOfLines={[1, 2, 3]} whiteSpace="wrap" maxW="200px">
                                                {hotel.description}
                                            </Text>
                                        </Box>
                                    </Td>
                                    <Td>{hotel.max_capacity}</Td>
                                    <Td>
                                        <Button
                                            colorScheme='orange'
                                            onClick={() => router.visit(`/hotels/${hotel.id}/update`)}
                                        >
                                            Modifier
                                        </Button>
                                    </Td>
                                    <Td>
                                        <Button
                                            colorScheme='red'
                                            onClick={()=>{
                                                setSelectedHotel(hotel.id);
                                                onOpen();
                                            }}
                                        >
                                            Supprimer
                                        </Button>

                                    </Td>
                                </Tr>
                            ))}
                        </Tbody>
                    </Table>
                </TableContainer>
            </div>

            {/* Boite de dialogue de confirmation de suppression d un hôtel */}
            <AlertDialog
                isOpen={isOpen}
                leastDestructiveRef={cancelRef}
                onClose={onClose}
            >

                <AlertDialogOverlay>
                    <AlertDialogContent>
                        <AlertDialogHeader fontSize='lg' fontWeight='bold'>
                            Supprimer l'hôtel
                        </AlertDialogHeader>

                        <AlertDialogBody>
                            Voulez-vous vraiment supprimer cet hôtel??
                        </AlertDialogBody>

                        <AlertDialogFooter>
                            <Button ref={cancelRef} onClick={onClose}>
                                Cancel
                            </Button>
                            <Button
                                colorScheme='red'
                                ml={3}
                                onClick={()=>{
                                    deleteHotel(selectedHotel);
                                    onClose();
                                }}
                            >
                                Delete
                            </Button>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialogOverlay>
            </AlertDialog>
            {/* fin boite de dialogue de suppression d'hotel*/}
        </>
    );
}
