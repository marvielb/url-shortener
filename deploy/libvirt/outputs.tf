output "ip-master" {
  value = libvirt_domain.domain-debian.network_interface[0].addresses[0]
}

output "ip-slave" {
  value = libvirt_domain.domain-debian-slave.network_interface[0].addresses[0]
}
